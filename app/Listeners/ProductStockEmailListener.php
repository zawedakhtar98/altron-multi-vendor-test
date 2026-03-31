<?php

namespace App\Listeners;

use App\Events\ProductStockEmailSenderEvent;
use App\Mail\SendEmails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProductStockEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    //When using Queued Listeners, you can define how many times the task should be retried:
    public $tries = 3;//Retry 3 times before giving up
    public $backoff = 60;// Wait 60 seconds between retries
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductStockEmailSenderEvent $event): void
    {
        // foreach($event->user as $k=> $val){
            Mail::to($event->email)->send(new SendEmails());
        // }
    }
}
