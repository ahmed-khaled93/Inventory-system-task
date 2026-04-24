<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\LowStockDetected; 
use Illuminate\Support\Facades\Log;

class SendLowStockAlert
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
    public function handle(LowStockDetected $event): void
    {
        Log::warning('Low stock alert', [
            'product_id' => $event->product->id,
            'sku' => $event->product->sku,
            'stock' => $event->product->stock_quantity,
        ]);
    }
}
