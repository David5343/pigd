<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class);
    }
}
