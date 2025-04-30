<?php

namespace App\Models\HumanResources;

use App\Models\Catalogs\Area;
use App\Models\Catalogs\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}
