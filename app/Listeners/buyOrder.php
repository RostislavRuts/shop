<?php

namespace App\Listeners;

use App\Events\addOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class buyOrder
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
     * @param  addOrder  $event
     * @return void
     */
    public function handle(addOrder $event)
    {
        \Log::info('Test from buyOrder', $event->order->toArray());
    }  
}
