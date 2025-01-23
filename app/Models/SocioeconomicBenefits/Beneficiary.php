<?php

namespace App\Models\SocioeconomicBenefits;

use App\Models\Catalogs\Bank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Beneficiary extends Model
{
    public function insured(): BelongsTo
    {
        return $this->belongsTo(Insured::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
