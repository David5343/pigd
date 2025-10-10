<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PensionType extends Model
{
    public function workRisks(): HasMany
    {
        return $this->hasMany(WorkRisk::class);
    }
}
