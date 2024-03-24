<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    /**
     * @OA\Post(
     *     path="/withdrawals",
     *     operationId="createWithdrawal",
     *     tags={"Withdrawals"},
     *     summary="Create a new withdrawal transaction",
     *     description="Creates a new withdrawal request for the authenticated user.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Withdrawal request details",
     *         @OA\JsonContent(
     *             required={"amount", "address"},
     *             @OA\Property(property="amount", type="number", format="float", description="The amount to withdraw", example=100.50),
     *             @OA\Property(property="address", type="string", description="The withdrawal address", example="1BoatSLRHtKNngkdXEeobR76b53LETtpyT")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The withdrawal transaction has been successfully created",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The withdrawal transaction has been successfully created")
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
}
