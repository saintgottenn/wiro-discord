<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\ProductLog;
use App\Models\ArchiveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProductLogResource;

class ProductLogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/offers/",
    *     operationId="getOffers",
     *     tags={"Offers"},
     *     summary="Get product logs",
     *     description="Retrieves product logs based on query parameters.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         description="Search term for product logs",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="seller_name",
     *         in="query",
     *         required=false,
     *         description="Seller name to filter by",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="country",
     *         in="query",
     *         required=false,
     *         description="Country to filter by",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ProductLog")
     *             )
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
     *     path="/offers/",
     *     operationId="storeOffer",
     *     tags={"Offers"},
     *     summary="Create product logs",
     *     description="Creates new product logs based on provided data.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product log data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"seller_id", "amount", "country"},
     *                     @OA\Property(property="seller_id", type="integer", example=1),
     *                     @OA\Property(property="amount", type="integer", example=100),
     *                     @OA\Property(property="country", type="string", example="US"),
     *                     @OA\Property(property="archive", type="string", format="binary")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Data processed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data processed successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ProductLog")
     *             )
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
     * @OA\Put(
     *     path="/offers//{id}",
     *     operationId="updateProductLog",
     *     tags={"Offers"},
     *     summary="Update a product log",
     *     description="Updates an existing product log.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product log to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         description="Product log data to update",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="amount", type="integer", example=150),
     *             @OA\Property(property="country", type="string", example="GB"),
     *             @OA\Property(property="on_sale", type="boolean", example=true),
     *             @OA\Property(property="archive", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data has been successfully updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data has been
     *  *             successfully updated"),
    *             @OA\Property(property="offer", ref="#/components/schemas/ProductLog")
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
    *         response=404,
    *         description="Not found"
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Unauthorized"
    *     )
    * )
    */
    public function update(Request $request, $id) {
        // Your existing method implementation
    }

    /**
     * @OA\Delete(
     *     path="/offers//{id}",
     *     operationId="deleteProductLog",
     *     tags={"Offers"},
     *     summary="Delete a product log",
     *     description="Deletes an existing product log.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product log to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data has been successfully deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data has been successfully deleted")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function delete($id) {
        // Your existing method implementation
    }

    /**
     * @OA\Get(
     *     path="/offers//hot",
     *     operationId="getHotProductLogs",
     *     tags={"Offers"},
     *     summary="Get hot product logs",
     *     description="Retrieves a list of hot product logs.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ProductLog")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function hotOffers(Request $request) {
        // Your existing method implementation
    }
}
