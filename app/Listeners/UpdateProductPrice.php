<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ProductUpdated;
use App\Jobs\UpdateProductPrices;

class UpdateProductPrice
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
     * @param  object  $event
     * @return void
     */
    public function handle(ProductUpdated $event)
    {
        // Lancia il Job in background per aggiornare i prezzi
        UpdateProductPrices::dispatch();
    }
}
