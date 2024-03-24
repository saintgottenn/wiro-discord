<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Retrieve all payment processes for the authenticated user
     *
     * @OA\Get(
     *     path="/payment/processes",
     *     summary="Retrieve all payment processes",
     *     tags={"Payment"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Wallet")
     *         )
     *     )
     * )
     */
    public function allProcesses(Request $request) 
    {
        // Method implementation
    }
    
    /**
     * Process a payment transaction
     *
     * @OA\Post(
     *     path="/payment/{currency}",
     *     summary="Process a payment transaction",
     *     tags={"Payment"},
     *     @OA\Parameter(
     *         name="currency",
     *         in="path",
     *         description="Currency code (e.g., USDT, BTC)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Payment process details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="unique_key", type="string", description="Unique key for the transaction"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction processed successfully",
     *         @OA\JsonContent(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function process(Request $request, $currency)
    {
        // Method implementation
    }

    /**
     * Get exchange rates for a specific currency
     *
     * @OA\Post(
     *     path="/payment/exchange/{currency}",
     *     summary="Get exchange rates",
     *     tags={"Payment"},
     *     @OA\Parameter(
     *         name="currency",
     *         in="path",
     *         description="Currency code (e.g., USD, EUR)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function getExchangeRates(Request $request, $currency)
    {   
        // Method implementation
    }
}