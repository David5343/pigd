<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class CatalogYear extends Model
{
    public function medicationPrices()
    {
        return $this->hasMany(MedicationPrice::class);
    }
}
