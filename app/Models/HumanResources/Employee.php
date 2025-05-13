<?php

namespace App\Models\HumanResources;

use App\Models\Catalogs\Area;
use App\Models\Catalogs\Position;
use App\Models\Catalogs\ProcedureType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $casts = [
        'start_date' => 'date', // Asegura que sea Carbon en lugar de string
    ];

    protected function startDateFormatted(): Attribute
    {
        return Attribute::get(
            fn () => $this->start_date?->format('d/m/Y')
        );
    }
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
    public function procedureType():BelongsTo
    {
        return$this->belongsTo(ProcedureType::class);
    }
}
