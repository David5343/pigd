<?php

namespace App\Models\SocioeconomicBenefits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rank extends Model
{
    public function insured(): HasMany
    {
        return $this->hasMany(Insured::class, 'rank_id');
    }
}
