<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class SupplierCategory extends Model
{
    protected $fillable = ['name'];

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_supplier_category');
    }
}
