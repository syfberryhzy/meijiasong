<?php

namespace App\Listeners;

use App\Events\IntegralEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IntegralEventListener
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
     * @param  IntegralEvent  $event
     * @return void
     */
    public function handle(IntegralEvent $event)
    {
        //
    }
}
