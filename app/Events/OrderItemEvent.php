<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class OrderItemEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $products;
    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($products, $order)
    {
        $this->products = $products;
        $this->order = $order;
    }
}
