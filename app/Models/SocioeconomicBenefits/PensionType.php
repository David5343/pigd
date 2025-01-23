<?php

namespace App\Models\SocioeconomicBenefits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PensionType extends Model
{
    public function retirees(): HasMany
    {
        return $this->hasMany(Retiree::class);
    }
}
