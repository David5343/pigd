<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'rfc', 'type'];

    public function categories()
    {
        return $this->belongsToMany(SupplierCategory::class, 'supplier_supplier_category');
    }
    public function medications()
    {
        return $this->hasMany(Medication::class);
    }
}
