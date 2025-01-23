<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class County extends Model
{
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
