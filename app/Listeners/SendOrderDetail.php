<?php

namespace App\Listeners;

use App\Events\OrderRegistered;
use App\Jobs\SendEmail;
use App\Mail\OrderDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderDetail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderRegistered $event): void
    {
        SendEmail::dispatch($event->order->user, new OrderDetail($event->order));
    }
}
