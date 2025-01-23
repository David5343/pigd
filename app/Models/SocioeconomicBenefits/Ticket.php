<?php

namespace App\Models\SocioeconomicBenefits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    public function insured(): BelongsTo
    {
        return $this->belongsTo(Insured::class);
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function retiree(): BelongsTo
    {
        return $this->belongsTo(Retiree::class);
    }
}
