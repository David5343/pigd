<?php

namespace App\Models\SocioeconomicBenefits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PensionerBeneficiary extends Model
{
    protected $table = 'pensioner_beneficiaries';
    public function pensioner(): BelongsTo
    {
        return $this->belongsTo(Pensioner::class);
    }
    public function credentials()
    {
        return $this->hasMany(CredentialPensionerBeneficiary::class, 'beneficiary_id');
    }
}
