<?php

namespace App\Models\SocioeconomicBenefits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CredentialPensionerBeneficiary extends Model
{
    public function pensionerBeneficiary(): BelongsTo
    {
        return $this->belongsTo(PensionerBeneficiary::class);
    }
}
