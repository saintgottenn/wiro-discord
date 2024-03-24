<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="productable_id", type="integer"),
 *     @OA\Property(property="productable_type", type="string"),
 * )
 */

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['productable_id', 'productable_type'];

    public function productable()
    {
        return $this->morphTo();
    }

}
