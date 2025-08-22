<?php

namespace App\Models\Catalogs;

use App\Models\SocioeconomicBenefits\Insured;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class County extends Model
{
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
    public function workplaceInsureds()
    {
        return $this->hasMany(Insured::class, 'workplace_county_id');
    }
    public function birthplaceInsureds()
    {
        return $this->hasMany(Insured::class, 'birthplace_county_id');
    }
    public function insureds()
    {
        return $this->hasMany(Insured::class, 'county_id');
    }
}
