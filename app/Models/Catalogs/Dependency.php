<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dependency extends Model
{
    protected $table = 'dependencies';

    public function subdependency(): HasMany
    {
        return $this->hasMany(Subdependency::class);
    }
}
