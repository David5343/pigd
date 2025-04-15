<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes;
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
