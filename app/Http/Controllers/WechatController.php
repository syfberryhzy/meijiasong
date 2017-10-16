<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Pay;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order as PayOrder;
use Carbon\Carbon;
use Validator;
use App\Events\OrderItemEvent;

class WechatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * 添加订单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $products = $request->products;
        $type = $request->type; //充值=> 1，购物 => 2
        $wxPay = Pay::PAY_WEIXIN_ID;
        $pay_id = $request->type == 1 ?  $wxPay: $request->pay_id;
        $data = array(
            'amount' => $request->amount,
            'total' => $request->total,
            'pay_id' => $pay_id
        );
        #验证

        //送货信息
        if ($type == 2) {
             $data['receiver'] = $request->receiver;
             $data['phone'] = $request->phone;
             $data['address'] = $request->address;
             $data['remarks'] = $request->remarks;
        }

        $data['user_id'] = \Auth::user()->id;
        $data['out_trade_no'] = config('wechat.app_id') . date("YmdHis") . rand(10, 99);
        // $data['status'] = $pay_id == 3 ? 21 : 1;
        $data['status'] = 1;
        // $data['prepay_id'] = $pay_id == 2 ? $this->getPrepayId($request, $data['out_trade_no']) : '';
        $data['prepay_id'] = '';

        $order = Order::create($data);

        // TODO 订单商品详情
        event(new OrderItemEvent($products, $order, \Auth::user()));

        // // TODO 生成订单金额分配
        // event(new OrderEvent($order, $products, Auth::user()));

        // TODO 生成订单之后 30 分钟执行 取消订单
        // $cancelOrderJob = (new CancelOrder($order, Auth::user()))->delay(Carbon::now()->addMinutes(30));
        // dispatch($cancelOrderJob);

        return response()->json(['data' => $order, 'status' => 1], 201);
    }
    /**微信统一下单
     * [getPrepayId description]
     * @param  [type] $request  [description]
     * @return [type]           [description]
     */
    public function getPrepayId($request, $out_trade_no)
    {
        $secret = config('wechat.secret');
        $params = array(
            'appid' => config('wechat.app_id'),
            'mch_id' => config('wechat.mch_id'),
            'nonce_str' => getNonceStr('32'),
            'body' => $request->type == 1 ? '美家送充值卡' : '美家送购物消费',
            'out_trade_no' => $out_trade_no,
            'total_fee' => (int)($request->total * 100),
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
            'trade_type' => 'JSAPI',
            'notify_url' => 'https://sharepay.mandokg.com/wechat/payment/notify',
            'openid' => \Auth::user()->openid
        );
        $params['sign'] = makeSign($params);
        $xml = toXml($params);
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $res = fromXml(postXmlCurl($xml, $url, false, 6));
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
