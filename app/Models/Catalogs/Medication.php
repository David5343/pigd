<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Medication extends Model
{
    public function prices()
    {
        return $this->hasMany(MedicationPrice::class);
    }
    public function medicationUnit()
    {
        return $this->belongsTo(MedicationUnit::class, 'medication_units_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function currentPrice()
    {
    $currentYear = Carbon::now()->year;

    return $this->prices()
        ->whereHas('catalogYear', function ($query) use ($currentYear) {
            $query->where('year', $currentYear);
        })
        ->first();
    }
    public function latestPrice()
    {
        return $this->prices()
            ->join('catalog_years', 'medication_prices.catalog_year_id', '=', 'catalog_years.id')
            ->orderByDesc('catalog_years.year')
            ->select('medication_prices.*') // necesario para evitar que Eloquent devuelva un objeto combinado
            ->first();
    }
}
