<?php

namespace App\Models\HumanResources;

use App\Models\Catalogs\Area;
use App\Models\Catalogs\ContractType;
use App\Models\Catalogs\Position;
use App\Models\Catalogs\ProcedureType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeProcedure extends Model
{

    protected $casts = [
        'effective_date' => 'date',
        'created_at' => 'date', // Asegura que sea Carbon en lugar de string
    ];

    protected function createdAtFormatted(): Attribute
    {
        return Attribute::get(
            fn () => $this->created_at?->format('d/m/Y')
        );
    }
    protected function effectiveDateFormatted(): Attribute
    {
        return Attribute::get(
            fn () => $this->effective_date?->format('d/m/Y')
        );
    }
    public function employee():BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function procedureType():BelongsTo
    {
        return$this->belongsTo(ProcedureType::class);
    }
    public function contractType():BelongsTo
    {
        return$this->belongsTo(ContractType::class);
    }
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
