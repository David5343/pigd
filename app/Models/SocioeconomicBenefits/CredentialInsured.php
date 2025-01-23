<?php

namespace App\Models\SocioeconomicBenefits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CredentialInsured extends Model
{
    public function insured(): BelongsTo
    {
        return $this->belongsTo(Insured::class);
    }
}
