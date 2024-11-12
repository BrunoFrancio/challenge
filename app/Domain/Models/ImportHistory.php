<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class ImportHistory extends Model
{
    protected $fillable = [
        'file_name',
        'imported_count',
        'imported_at',
        'product_ids',
    ];

    protected $casts = [
        'product_ids' => 'array',
        'imported_at' => 'datetime',
    ];
}
