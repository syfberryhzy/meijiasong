<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\OrderEvent' => [
            'App\Listeners\OrderEventListener',
        ],
        'App\Events\OrderItemEvent' => [
            'App\Listeners\OrderItemEventListener',
        ],
        'App\Events\IntegralEvent' => [
            'App\Listeners\IntegralEventListener',
        ],
        'App\Events\BalanceEvent' => [
            'App\Listeners\BalanceEventListener',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
