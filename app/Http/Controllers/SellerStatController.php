<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;

class SellerStatController extends Controller
{
    public function stats(Request $request, $start_date = null, $end_date = null)
    {
        $start_date = $start_date ?: ($request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::minValue());
        $end_date = $end_date ?: ($request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::maxValue());

        $purchasesCount = Order::where('seller_id', $request->user()->id)
            ->where('status', 'Confirmed')
            ->where('created_at', '>=', $start_date)
            ->where('created_at', '<=', $end_date)
            ->count();
            
        $refundedCount = Order::where('seller_id', $request->user()->id)
            ->where('status', 'Refunded')
            ->where('created_at', '>=', $start_date)
            ->where('created_at', '<=', $end_date)
            ->count();

        return response()->json([
            'purchases_count' => $purchasesCount,
            'refunded_count' => $refundedCount,
        ]);
    }
}
