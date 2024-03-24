<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WithdrawalController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'type' => 'Withdrawal',
            'status' => 'Processing',
            'amount' => $request->amount . '$',
        ]);

        Withdrawal::create([
            'user_id' => $request->user()->id,
            'transaction_id' => $transaction->id,
            'amount' => $request->amount . '$',
            'address' => $request->address,
        ]);

        return response()->json(['message' => 'The withdrawal transaction has been successfully created']);
    }
}
