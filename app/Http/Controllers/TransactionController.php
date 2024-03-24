<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function allTransactions(Request $request)
    {
        $transactions = TransactionResource::collection(Transaction::where('user_id', $request->user()->id)->latest()->paginate(10))->response()->getData(true);

        return response()->json($transactions);
    }

}
