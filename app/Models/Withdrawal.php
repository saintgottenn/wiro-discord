<?php

namespace App\Models;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'transaction_id', 'amount', 'address'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('available', function (Builder $builder) {
            $builder->whereHas('transaction', function ($query) {
                $query->where('status', 'Processing');
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Определение связи с моделью Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
