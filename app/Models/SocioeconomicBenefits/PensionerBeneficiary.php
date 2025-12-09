<?php

namespace App\Models\SocioeconomicBenefits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PensionerBeneficiary extends Model
{
    protected $table = 'pensioner_beneficiaries';
    protected $primaryKey = 'id';
    public function pensioner(): BelongsTo
    {
        return $this->belongsTo(Pensioner::class);
    }
}
