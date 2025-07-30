<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class MedicationUnit extends Model
{
    public function medications()
    {
        return $this->hasMany(Medication::class, 'medication_units_id');
    }
}
