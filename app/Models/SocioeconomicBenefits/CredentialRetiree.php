<?php

namespace App\Models\SocioeconomicBenefits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CredentialRetiree extends Model
{
    public function retiree(): BelongsTo
    {
        return $this->belongsTo(Retiree::class);
    }
}
