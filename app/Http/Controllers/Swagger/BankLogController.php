<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BankLogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/banks",
     *     operationId="getbanks",
     *     tags={"Banks"},
     *     summary="Get bank logs",
     *     description="Retrieves bank logs based on query parameters.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="bank_link",
     *         in="query",
     *         required=false,
     *         description="Bank link to filter by",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="balance",
     *         in="query",
     *         required=false,
     *         description="Balance to filter by",
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
     *                 @OA\Items(ref="#/components/schemas/BankLog")
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
     *     path="/banks",
     *     operationId="storeBankLog",
     *     tags={"Banks"},
     *     summary="Create bank logs",
     *     description="Creates new bank logs based on provided data.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Bank log data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"seller_id", "amount", "balance", "bank_link"},
     *                     @OA\Property(property="seller_id", type="integer", example=1),
     *                     @OA\Property(property="amount", type="integer", example=100),
     *                     @OA\Property(property="balance", type="string", example="500"),
     *                     @OA\Property(property="bank_link", type="string", example="https://www.examplebank.com/user"),
     *                     @OA\Property(property="archive", type="string", format="binary"),
     *                     @OA\Property(property="image", type="string", format="binary")
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
     *                 @OA\Items(ref="#/components/schemas/BankLog")
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
     *     path="/banks/{id}/update",
     *     operationId="updateBankLog",
     *     tags={"Banks"},
     *     summary="Update a bank log",
     *     description="Updates an existing bank log.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the bank log to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         description="Bank log data to update",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="amount", type="integer", example=100),
     *             @OA\Property(property="bank_link", type="string", example="https://www.examplebank.com/newuser"),
     *             @OA\Property(property="balance", type="string", example="600"),
     *             @OA\Property(property="on_sale", type="boolean", example=true),
     *             @OA\Property(property="archive", type="string", format="binary"),
     *             @OA\Property(property="image", type="string", format="binary")
     *         )
      *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Data has been successfully updated",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Data has been successfully updated"),
    *             @OA\Property(property="bankLog", ref="#/components/schemas/BankLog")
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
     *     path="/banks/{id}/delete",
     *     operationId="deleteBankLog",
     *     tags={"Banks"},
     *     summary="Delete a bank log",
     *     description="Deletes an existing bank log.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the bank log to delete",
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
}
