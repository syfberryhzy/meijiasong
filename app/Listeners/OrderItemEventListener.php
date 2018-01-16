<?php

namespace App\Listeners;

use App\Events\OrderItemEvent;
use App\Models\OrderItem;

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
        $order = $event->order;
        collect($event->products)->map(function ($item, $key) use ($order) {
            return [
                'product_id' => $item->options->product_id,
                'name' => $item->name,
                'price' => $item->price,
                'number' => $item->qty,
                'amount' => $order->type == 1 ? $item->amount : ($item->price) * ($item->qty),
                'order_id' => $order->id,
                'attributes' => '',
            ];
        });
        OrderItem::insert($data);
    }
}
