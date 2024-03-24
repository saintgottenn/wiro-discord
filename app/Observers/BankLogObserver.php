<?php

namespace App\Observers;

use App\Models\BankLog;
use App\Models\Product;

class BankLogObserver
{
    /**
     * Handle the BankLog "created" event.
     *
     * @param  \App\Models\BankLog  $bankLog
     * @return void
     */
    public function created(BankLog $bankLog)
    {
        Product::create([
            'productable_id' => $bankLog->id,
            'productable_type' => BankLog::class,
        ]);
    }

    /**
     * Handle the BankLog "updated" event.
     *
     * @param  \App\Models\BankLog  $bankLog
     * @return void
     */
    public function updated(BankLog $bankLog)
    {
        //
    }

    /**
     * Handle the BankLog "deleted" event.
     *
     * @param  \App\Models\BankLog  $bankLog
     * @return void
     */
    public function deleted(BankLog $bankLog)
    {
        //
    }

    /**
     * Handle the BankLog "restored" event.
     *
     * @param  \App\Models\BankLog  $bankLog
     * @return void
     */
    public function restored(BankLog $bankLog)
    {
        //
    }

    /**
     * Handle the BankLog "force deleted" event.
     *
     * @param  \App\Models\BankLog  $bankLog
     * @return void
     */
    public function forceDeleted(BankLog $bankLog)
    {
        //
    }
}
