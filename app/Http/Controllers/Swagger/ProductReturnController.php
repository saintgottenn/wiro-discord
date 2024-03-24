<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductReturnController extends Controller
{
    /**
     * @OA\Get(
     *     path="/returns",
     *     operationId="getProductReturns",
     *     tags={"Product Returns"},
     *     summary="List all product returns",
     *     description="Retrieves a list of all product return requests.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ProductReturn")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request) {
        // Your existing method implementation
    }

    /**
     * @OA\Post(
     *     path="/returns",
     *     operationId="storeProductReturn",
     *     tags={"Product Returns"},
     *     summary="Create a product return request",
     *     description="Submits a new product return request.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product return data",
     *         @OA\JsonContent(
     *             required={"purchase_id", "subject"},
     *             @OA\Property(property="purchase_id", type="integer", example=1),
     *             @OA\Property(property="subject", type="string", example="Defective product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product return request created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product return request created successfully"),
     *             @OA\Property(property="id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="You have already submitted a request",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", example={"message": "You have already submitted a request"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(Request $request) {
        // Your existing method implementation
    }

    /**
     * @OA\Patch(
     *     path="/returns/{id}/refund",
     *     operationId="refundProductReturn",
     *     tags={"Product Returns"},
     *     summary="Refund a product return",
     *     description="Processes the refund for a product return request.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the product return",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The funds have been successfully refunded. The request is closed successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The funds have been successfully refunded. The request is closed successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function refund(Request $request, $id) {
        // Your existing method implementation
    }

    /**
     * @OA\Patch(
     *     path="/returns/{id}/close",
     *     operationId="closeProductReturn",
     *     tags={"Product Returns"},
     *     summary="Close a product return request",
     *     description="Closes a product return request without a refund.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the product return to close",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Request is closed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Request is closed successfully")
     *         )
     *     ),
     *    
     *  *     @OA\Response(
 *         response=404,
 *         description="Not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */
public function close(Request $request, $id) {
    // Your existing method implementation
}

/**
 * @OA\Get(
 *     path="/returns/{id}",
 *     operationId="showProductReturn",
 *     tags={"Product Returns"},
 *     summary="Show a product return request",
 *     description="Retrieves details of a specific product return request.",
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the product return",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Product return details retrieved successfully"),
 *             @OA\Property(property="product_return", ref="#/components/schemas/ProductReturn")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */
public function show(Request $request, $id) {
    // Your existing method implementation
}
}