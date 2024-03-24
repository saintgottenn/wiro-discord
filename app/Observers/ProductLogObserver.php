<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductLog;

class ProductLogObserver
{
    /**
     * Handle the ProductLog "created" event.
     *
     * @param  \App\Models\ProductLog  $productLog
     * @return void
     */
    public function created(ProductLog $productLog)
    {
        Product::create([
            'productable_id' => $productLog->id,
            'productable_type' => ProductLog::class,
        ]);
    }

    /**
     * Handle the ProductLog "updated" event.
     *
     * @param  \App\Models\ProductLog  $productLog
     * @return void
     */
    public function updated(ProductLog $productLog)
    {
        //
    }

    /**
     * Handle the ProductLog "deleted" event.
     *
     * @param  \App\Models\ProductLog  $productLog
     * @return void
     */
    public function deleted(ProductLog $productLog)
    {
        //
    }

    /**
     * Handle the ProductLog "restored" event.
     *
     * @param  \App\Models\ProductLog  $productLog
     * @return void
     */
    public function restored(ProductLog $productLog)
    {
        //
    }

    /**
     * Handle the ProductLog "force deleted" event.
     *
     * @param  \App\Models\ProductLog  $productLog
     * @return void
     */
    public function forceDeleted(ProductLog $productLog)
    {
        //
    }
}
