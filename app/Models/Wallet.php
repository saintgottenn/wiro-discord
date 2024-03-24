<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Wallet",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="unique_key", type="string"),
 *     @OA\Property(property="address", type="string"),
 *     @OA\Property(property="private_wif", type="string", format="password", description="Private Wallet Import Format (WIF) key"),
 * )
 */

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['unique_key', 'address', 'private_wif'];

    protected $hidden = [
        'private_wif',
    ];
}
