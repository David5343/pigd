<?php

namespace App\Models\Catalogs;

use App\Models\SocioeconomicBenefits\Beneficiary;
use App\Models\SocioeconomicBenefits\Insured;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    public function insured(): HasMany
    {
        return $this->hasMany(Insured::class);
    }

    public function beneficiary(): HasMany
    {
        return $this->hasMany(Beneficiary::class);
    }
}
