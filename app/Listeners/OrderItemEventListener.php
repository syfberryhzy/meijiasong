<?php

namespace App\Listeners;

use App\Events\OrderItemEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
            $data =  array(
                'product_id' => $item->options->product_id,
                'name' => $item->name,
                'price' => $item->price,
                'number' => $item->qty,
                'amount' => ($item->price) * ($item->qty),
                'order_id' => $order->id,
                'attributes' => '',
            );
            $order->items()->create($data);
        });
    }
}
