<?php

namespace App\Models\SocioeconomicBenefits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Retiree extends Model
{
    public function insured(): BelongsTo
    {
        return $this->belongsTo(Insured::class);
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function pensionType(): BelongsTo
    {
        return $this->belongsTo(PensionType::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
