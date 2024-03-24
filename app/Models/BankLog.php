<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\ArchiveFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @OA\Schema(
 *     schema="BankLog",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="seller_id", type="integer"),
 *     @OA\Property(property="amount", type="integer"),
 *     @OA\Property(property="balance", type="string"),
 *     @OA\Property(property="bank_link", type="string"),
 *     @OA\Property(property="archive_link", type="string"),
 *     @OA\Property(property="image_link", type="string"),
 *     @OA\Property(property="on_sale", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class BankLog extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id', 'amount', 'archive_link', 'image_link', 'bank_link', 'is_sold', 'on_sale', 'balance'];

    protected $casts = [
        'created_at' => 'datetime:Y.m.d',
        'updated_at' => 'datetime:Y.m.d',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('available', function (Builder $builder) {
            $builder->where('is_sold', 0)->where('on_sale', 1);
        });
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function archiveFiles()
    {
        return $this->morphMany(ArchiveFile::class, 'archivable');
    }

    public function product()
    {
        return $this->morphOne(Product::class, 'productable');
    }
}
