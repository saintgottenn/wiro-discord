<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Transaction",
 *     type="object",
 *     required={"amount", "type", "status", "user_id"},
 *     @OA\Property(
 *         property="amount",
 *         type="number",
 *         format="float",
 *         description="The amount of the transaction",
 *         example=150.00
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="The type of the transaction",
 *         example="deposit"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="The current status of the transaction",
 *         example="Successfully"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="The ID of the user associated with the transaction",
 *         example=1
 *     )
 * )
 */

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'type', 'status', 'user_id'];
}
