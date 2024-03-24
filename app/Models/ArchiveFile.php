<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveFile extends Model
{
    use HasFactory;

    protected $fillable = ['keyword', 'archivable_id', 'archivable_type'];

    public function archivable()
    {
        return $this->morphTo();
    }
}
