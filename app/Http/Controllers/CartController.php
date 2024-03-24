<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Jobs\PurchaseConfirmationJob;

class CartController extends Controller
{
    public function getProducts(Request $request)
    {
        $products = $this->getProductsByIds($request->products);
        
        return response()->json($products);
    }

    protected function getProductsByIds($ids) 
    {
        $products = Product::whereIn('id', $ids)->get();

        $products = $products->map(function ($product) {
            $productable = $product->productable;

            $productable->seller = User::find($productable->seller_id);

            return $productable;
        });

        return $products;
    }

    public function buy(Request $request)
    {
        $products = $this->getProductsByIds($request->products);

        $finalPrice = $products->sum(function($product) {
            return $product->amount;
        });
        
        if($finalPrice <= $request->user()->balance) {
            
            foreach($products as $product) {
                $order = Order::create([
                    'product_id' => $product->product->id,
                    'seller_id' => $product->seller_id,
                    'buyer_id' => $request->user()->id,
                    'status' => 'Pre-confirmed',
                    'amount' => $product->amount,
                ]);

                Purchase::create([
                    'user_id' => $request->user()->id,
                    'order_id' => $order->id,
                ]);

                $productModel = Product::find($product->product->id);

                $productModel->productable->is_sold = true;
                $productModel->productable->save();

                PurchaseConfirmationJob::dispatch($order)->delay(now()->addSeconds(60));
            }

            return response()->json(['message' => 'Products have been successfully purchased', 'success' => true]);
        } 
        
        return response()->json(['errors' => ['balance' => 'Insufficient funds on the balance sheet']]);
    }
}
