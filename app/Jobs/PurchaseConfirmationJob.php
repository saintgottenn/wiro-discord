<?php

namespace App\Jobs;

use App\Models\Order;
use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PurchaseConfirmationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->order->status === 'Pre-confirmed') {
            $this->order->status = 'Confirmed';
            $this->order->save();

            $sellerBalance = BigDecimal::of($this->order->seller->balance);
            $orderAmount = BigDecimal::of($this->order->amount);

            $newSellerBalance = $sellerBalance->plus($orderAmount);

            $this->order->seller->balance = $newSellerBalance->toScale(2, RoundingMode::HALF_UP);
            $this->order->seller->save();
        }
    }
}
