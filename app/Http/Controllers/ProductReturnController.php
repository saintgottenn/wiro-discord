<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BankLog;
use App\Models\Purchase;
use App\Models\ProductLog;
use Brick\Math\BigDecimal;
use Illuminate\Http\Request;
use App\Models\ProductReturn;
use App\Jobs\PurchaseConfirmationJob;
use Illuminate\Support\Facades\Validator;

class ProductReturnController extends Controller
{
    public function index(Request $request)
    {   
        $returns = ProductReturn::latest()->paginate(20);

        $returns->transform(function($item) {
            $product = $item->purchase->order->product;

            $productable = '';

            if($product->productable_type === ProductLog::class) {
                $productable = ProductLog::withoutGlobalScope('available')->find($product->productable_id);
            }

            if($product->productable_type === BankLog::class) {
                $productable = BankLog::withoutGlobalScope('available')->find($product->productable_id);
            } 

            $itemArray = $item->toArray();
            unset($itemArray['purchase']);
            $item = collect($itemArray);

            $item->put('product', $productable);

            return $item;
        });

        return response()->json($returns);
    }   

    public function store(Request $request)
    {
        $returnIsExists = ProductReturn::where('purchase_id', $request->purchase_id)->exists();

        if($returnIsExists) {
             return response()->json(['errors' => ['message' => 'You have already submitted a request']], 404);
        }

        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required|integer|exists:purchases,id',
            'subject' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = Purchase::find($request->purchase_id)->order;
        $product = $order->product;

        $productable = '';

        if($product->productable_type === ProductLog::class) {
            $productable = ProductLog::withoutGlobalScope('available')->find($product->productable_id);
        }

        if($product->productable_type === BankLog::class) {
            $productable = BankLog::withoutGlobalScope('available')->find($product->productable_id);
        } 
        
        $return = ProductReturn::create([
            'user_id' => $request->user()->id,
            'seller_id' => $productable->seller_id,
            'purchase_id' => $request->purchase_id,
            'subject' => $request->subject,
            'amount' => $productable->amount,
        ]);

        $order->status = 'Checking';
        $order->save();

        return response()->json([   
            'message' => 'Product return request created successfully',
            'id' => $return->id,
        ]);
    }

    public function refund(Request $request, $id)
    {
        $return = ProductReturn::find($id);

        if($return === null) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $user = User::find($return->user_id);
        
        if($user === null) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $userBalance = BigDecimal::of($user->balance);
        $returnAmount = BigDecimal::of($return->amount);

        $newBalance = $userBalance->plus($returnAmount);

        $user->balance = (string) $newBalance;
        $user->save();

        $return->is_opened = false;
        $return->save();

        $return->purchase->order->status = 'Refunded';
        $return->purchase->order->save();

        $purchase = Purchase::find($return->purchase_id);
        
        if($purchase) {
            $purchase->delete();
        }

        return response(['message' => 'The funds have been successfully refunded. The request is closed successfully']);
    }

    public function close(Request $request, $id)
    {
        $return = ProductReturn::find($id);

        if($return === null) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $return->is_opened = false;
        $return->save();

        $return->purchase->order->status = 'Pre-confirmed';
        $return->purchase->order->save();

        PurchaseConfirmationJob::dispatch($return->purchase->order);

        return response(['message' => 'Request is closed successfully']);
    }

    public function show(Request $request, $id)
    {
        $return = ProductReturn::find($id);

        if($return === null) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $product = $return->purchase->order->product;

        $productable = '';

        if($product->productable_type === ProductLog::class) {
            $productable = ProductLog::withoutGlobalScope('available')->find($product->productable_id);
        }

        if($product->productable_type === BankLog::class) {
            $productable = BankLog::withoutGlobalScope('available')->find($product->productable_id);
        } 

        $returnArray = $return->toArray();
        unset($returnArray['purchase']);
        $returnArray['product'] = $productable;

        return response()->json($returnArray);
        
    }
}
