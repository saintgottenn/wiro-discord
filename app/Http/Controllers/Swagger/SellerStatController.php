<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerStatController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user/stats",
     *     operationId="getSellerStats",
     *     tags={"SellerStats"},
     *     summary="Get statistics for a seller",
     *     description="Retrieves statistics for the authenticated seller within a specified date range.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         required=false,
     *         description="Start date for the statistics period in YYYY-MM-DD format",
     *         @OA\Schema(type="string", format="date", example="2024-01-01")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         required=false,
     *         description="End date for the statistics period in YYYY-MM-DD format",
     *         @OA\Schema(type="string", format="date", example="2024-01-31")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="purchases_count", type="integer", example=25, description="The number of confirmed purchases."),
     *             @OA\Property(property="refunded_count", type="integer", example=5, description="The number of refunded orders.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function stats(Request $request, $start_date = null, $end_date = null) {
        // Your existing method implementation
    }
}
