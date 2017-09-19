<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order as PayOrder;
use Carbon\Carbon;

class WechatController extends Controller
{
    /*创建订单*/
    public function create(Application $application, Order $order)
    {


        $attributes = [
          'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
          'body'             => $order['name'],
          'detail'           => $order['attributes'],
          'out_trade_no'     => config('wechat.app_id').config('wechat.app_id').Carbon::now(),
          'total_fee'        => $order['total'] * 100, // 单位：分
          'notify_url'       => config('app.url').'http://xxx.com/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
          'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
          // ...
        ];
        $order = new PayOrder($attributes);
        $payment = $application->payment;
        dd($payment);
        $this->prepay($payment);
    }

    /*统一下单*/
    public function prepay($payment)
    {
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            return $prepayId = $result->prepay_id;
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
