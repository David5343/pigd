<?php

namespace App\Models\Catalogs;

use App\Models\SocioeconomicBenefits\Insured;
use Illuminate\Database\Eloquent\Model;

class AffiliationStatus extends Model
{
    public function insureds()
    {
        return $this->hasMany(Insured::class);
    }
}
