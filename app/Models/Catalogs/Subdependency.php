<?php

namespace App\Models\Catalogs;

use App\Models\SocioeconomicBenefits\Insured;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subdependency extends Model
{
    protected $table = 'subdependencies';

    public function dependency(): BelongsTo
    {
        return $this->belongsTo(Dependency::class);
    }

    public function insured(): HasMany
    {
        return $this->hasMany(Insured::class, 'subdependency_id');
    }
}
