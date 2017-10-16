<?php

namespace App\Listeners;

use App\Events\BalanceEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BalanceEventListener
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
     * @param  BalanceEvent  $event
     * @return void
     */
    public function handle(BalanceEvent $event)
    {
        //
    }
}
