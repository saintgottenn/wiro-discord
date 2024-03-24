<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\ArchiveFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @OA\Schema(
 *     schema="ProductLog",
 *     type="object",
 *     required={"seller_id", "amount", "archive_link", "country"},
 *     @OA\Property(
 *         property="seller_id",
 *         type="integer",
 *         description="The ID of the seller associated with the product log",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="integer",
 *         description="The amount or value associated with the product log",
 *         example=100
 *     ),
 *     @OA\Property(
 *         property="archive_link",
 *         type="string",
 *         description="URL to the archive containing product log details",
 *         example="http://example.com/archives/productlog1.zip"
 *     ),
 *     @OA\Property(
 *         property="is_sold",
 *         type="boolean",
 *         description="Indicates whether the product log has been sold",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="country",
 *         type="string",
 *         description="The country associated with the product log",
 *         example="US"
 *     ),
 *     @OA\Property(
 *         property="on_sale",
 *         type="boolean",
 *         description="Indicates whether the product log is available for sale",
 *         example=true
 *     )
 * )
 */

class ProductLog extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id', 'amount', 'archive_link', 'is_sold', 'country', 'on_sale'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('available', function (Builder $builder) {
            $builder->where('is_sold', 0)->where('on_sale', 1);
        });
    }

    protected $casts = [
        'created_at' => 'datetime:Y.m.d',
        'updated_at' => 'datetime:Y.m.d',
    ];


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
