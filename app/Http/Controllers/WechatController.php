<?php

namespace App\Http\Controllers;

use App\Jobs\CancelOrder;
use App\Policies\ConfigPolicy;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pay;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order as PayOrder;
use Carbon\Carbon;
use Validator;
use App\Events\OrderItemEvent;
use App\Events\OrderEvent;
use Cart;
use Log;

class WechatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['update']);
    }


    public function defaultAddress()
    {
        $address = auth()->user()->defaultAddress();
        return $address;
    }

    /**
     * 添加订单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $wxPay = Pay::PAY_WEIXIN_ID;
        $type = $request->type ?: 2; //充值=> 1，购物 => 2
        $pay_id = $type == 1 ?  $wxPay: $request->pay_id;
        $data = array(
            'amount' => $request->amount,
            'total' => $request->total,
            'discount' => $request->discount,
            'pay_id' => $pay_id,
            'type' => $type,
            'is_discount' => $request->discount > 0 ? 1 : 0,//是否使用抵扣
        );
        if ($pay_id == 1 && $user->balance < $request->amount) {
            return response()->json(['data' => '', 'status' => 0], 422);
        }

        //送货信息
        if ($type == 2) {
             $address = $user->defaultAddress()->only(['receiver', 'phone', 'areas', 'details']);
             $data['receiver'] = $address['receiver'];
             $data['phone'] = $address['phone'];
             $data['address'] = $address['areas'] . $address['details'];
             $data['remarks'] = $request->remarks;//备注
        }
        $data['out_trade_no'] = date("YmdHis") . rand(1000, 9999);
        $data['prepay_id'] = $pay_id == 2 ? $this->getPrepayId($request, $data['out_trade_no']) : '';
        $order = $user->order()->create($data);
        //获取购物车商品
        if ($cart = request()->cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart['id'],
                'name' => $cart['name'],
                'price' => $cart['price'],
                'number' =>$cart['number'],
                'amount' => request()->amount,
                'attributes' => $cart['attributes']
            ]);
        } else {
            $carts = $this->getCartContent();
            // TODO 订单商品详情
            event(new OrderItemEvent($carts, $order));
            // TODO 清理购物车
            $this->deleteCart();
        }
        #15分钟自动取消待付款
        CancelOrder::dispatch($order)->delay(Carbon::now()->addMinutes(1));
        return response()->json(['data' => $order, 'status' => 1], 201);
    }

    public function update(Request $request)
    {
        \Log::info('回调开始');
        if ($request->out_trade_no) {
            $order = Order::where('out_trade_no', '=', $request->out_trade_no)->firstOrFail();
            if ($order['pay_id'] == 1 && $order->user->balance < $order['total']) {
                return response()->json(['info' => '余额不足，请先充值', 'status' => 0], 422);
            }
        } else {
            $result = fromXml($request->getContent());
            $order = Order::where('out_trade_no', '=', $result['out_trade_no'])->firstOrFail();
        }

        if (21 === $order['status'] || 41 === $order['status']) {
            return toXml(array('return_code' => 'SUCCESS', 'return_msg' => 'OK'));
        }
        $status = $order['type'] == 1 ? 41: 21;
        $order->update([
            'status' => $status
        ]);
        #后续操作
        $order->ifShopping();
        $order->ifRecharge();

        \Log::info('回调jeishu ');
        return toXml(array('return_code' => 'SUCCESS', 'return_msg' => 'OK'));
    }

    /**微信统一下单
     * @return [type]           [description]
     */
    public function getPrepayId($request, $out_trade_no)
    {
        $params = array(
            'appid' => config('wechat.mini_program.app_id'),
            'mch_id' => config('wechat.payment.merchant_id'),
            'nonce_str' => getNonceStr('32'),
            'body' => $request->type == 1 ? '美家送充值卡' : '美家送购物消费',
            'out_trade_no' => $out_trade_no,
            // 'total_fee' => (int)($request->total * 100),
            'total_fee' => 1,
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
            'trade_type' => 'JSAPI',
            'notify_url' => 'http://meijiasong.mandokg.com/wechat/payment/notify',
            'openid' => auth()->user()->openid
        );

        $params['sign'] = makeSign($params);
        $xml = toXml($params);
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $res = fromXml(postXmlCurl($xml, $url, false, 6));
        // dd($params,$xml, $res);
        if ($res['return_code'] == 'SUCCESS') {
            return $res['prepay_id'];
        } else {
            return response()->json(array('info' => $res['return_msg']), 400);
        }
    }



    // 支付结果通知
    public function handleNotify()
    {
        $response = $app->payment->handleNotify($this->getNotify($notify, $successful));
        return $response;
    }

    public function getNotify($notify, $successful)
    {
        // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
        $order = 查询订单($notify->out_trade_no);
        if (!$order) { // 如果订单不存在
            return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
        }
        // 如果订单存在
        // 检查订单是否已经更新过支付状态
        if ($order->paid_at) { // 假设订单字段“支付时间”不为空代表已经支付
            return true; // 已经支付成功了就不再更新了
        }
        // 用户是否支付成功
        if ($successful) {
            // 不是已经支付状态则修改为已经支付状态
            $order->paid_at = time(); // 更新支付时间为当前时间
            $order->status = 'paid';
        } else { // 用户支付失败
            $order->status = 'paid_fail';
        }
        $order->save(); // 保存订单
        return true; // 返回处理完成
    }
}
