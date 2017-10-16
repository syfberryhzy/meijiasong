<?php

namespace App\Listeners;

use App\Events\OrderItemEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\MOdels\OrderItem;

class OrderItemEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderItemEvent  $event
     * @return void
     */
    public function handle(OrderItemEvent $event)
    {
        #添加订单商品详情
        $datas = [];
        $data = array(
          'user_id' => $event->user->id,
          'order_id' => $event->order->id,
        );
        foreach ($event->products as $val) {
          // dd($val);
             $data['product_id'] = $val['id'];
             $data['name'] = $val['name'];
             $data['price'] = $val['price'];
             $data['number'] = $val['number'];
             $data['amount'] = ($val['price']) * ($val['number']);
             $data['attributes'] = $val['attributes'];
             $datas[] = $data;
        }
        OrderItem::insert($data);
        // 积分抵扣
        // 积分奖励
        // 支付余额扣除
    }
}
