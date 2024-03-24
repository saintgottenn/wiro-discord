<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CartController extends Controller
{
    /**
     * @OA\Get(
     *     path="/cart/",
     *     operationId="getCartProducts",
     *     tags={"Cart"},
     *     summary="Get products in the cart",
     *     description="Retrieves product information for the specified product IDs in the cart.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="products",
     *         in="query",
     *         required=true,
     *         description="Array of product IDs",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(type="integer", format="int64")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getProducts(Request $request) {
        // Your existing method implementation
    }

    /**
     * @OA\Post(
     *     path="/cart/buy",
     *     operationId="buyProducts",
     *     tags={"Cart"},
     *     summary="Purchase products in the cart",
     *     description="Processes a purchase transaction for the specified products by the authenticated user.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request body for buying products",
     *         @OA\JsonContent(
     *             required={"products"},
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(type="integer", format="int64"),
     *                 description="Array of product IDs to purchase"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Products have been successfully purchased",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Products have been successfully purchased"),
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", example={"balance": "Insufficient funds on the balance sheet"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function buy(Request $request) {
        // Your existing method implementation
    }
}