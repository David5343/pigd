<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class MedicationPrice extends Model
{
    protected $fillable = [
        'medication_id',
        // 'catalog_year_id',
        // 'unit_price',
        // 'modified_by',
    ];
    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    public function catalogYear()
    {
        return $this->belongsTo(CatalogYear::class);
    }
}
