<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function allProcesses(Request $request) 
    {
        $processes = Wallet::where('user_id', $request->user()->id)->latest()->get();

        return response()->json($processes);
    }
    
    public function process(Request $request, $currency)
    {
        $currency = strtoupper($currency);
        
        if(!$request->has('unique_key')) {
            return response()->json(['errors' => ['unique_key' => 'Unique key is required']], 422);
        }
        
        if($currency !== 'USDT' && $currency !== 'BTC') {
            return response()->json(['errors' => ['currency' => 'Currency is required']], 422);
        }
        
        $response = Http::post("127.0.0.1:3010/check-transactions", [
            'uniqueKey' => $request->unique_key,
            'userId' => $request->user()->id,
            'currency' => $currency,
        ]);
        
        if ($response->successful()) {
            $responseData = $response->json();

            if($responseData !== false) {
                
                Transaction::create([
                    'user_id' => $request->user()->id,
                    'amount' => $responseData['usdValue'],
                    'type' => 'Deposit',
                    'status' => 'Successfully',
                ]);

                return response()->json(true);
            } 

            return response()->json(false);
        } else {
            $errorCode = $response->status(); 
            $errorMessage = $response->body(); 
            
            return response()->json($errorMessage, $errorCode);
        }
    }

    public function getExchangeRates(Request $request, $currency)
    {   
        $response = Http::post("127.0.0.1:3010/exchange", [
            'currency' => $currency,
        ]);

        if ($response->successful()) {
            $responseData = $response->json();

            return response()->json($responseData);
        } else{
            $errorCode = $response->status(); 
            $errorMessage = $response->body(); 
            
            return response()->json($errorMessage, $errorCode);
        }
    }
}
