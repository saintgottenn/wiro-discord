<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @OA\Schema(
 *     schema="Ticket",
 *     required={"user_id", "seller_id", "subject", "amount", "status"},
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="The ID of the user who created the ticket",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="seller_id",
 *         type="integer",
 *         description="The ID of the seller associated with the ticket",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="subject",
 *         type="string",
 *         description="The subject of the ticket",
 *         example="Need assistance with product"
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="number",
 *         format="float",
 *         description="The amount associated with the ticket, if any",
 *         example=99.99
 *     ),
 *     @OA\Property(
 *         property="is_opened",
 *         type="boolean",
 *         description="The current status of the ticket",
 *         example=true
 *     )
 * )
 */

class Ticket extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'seller_id', 'subject', 'amount', 'status'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('available', function (Builder $builder) {
            $builder->where('is_opened', 1);
        });
    }

    protected $casts = [
        'created_at' => 'datetime:Y.m.d',
        'updated_at' => 'datetime:Y.m.d',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
