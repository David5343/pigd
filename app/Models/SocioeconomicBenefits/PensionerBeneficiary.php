<?php

namespace App\Models\SocioeconomicBenefits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PensionerBeneficiary extends Model
{
        public function pensioner(): BelongsTo
    {
        return $this->belongsTo(Pensioner::class);
    }
}
