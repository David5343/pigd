<?php

namespace App\Models\HumanResources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeProcedureDetail extends Model
{
    use SoftDeletes;

    public function employeeProcedure():BelongsTo
    {
        return $this->belongsTo(EmployeeProcedure::class);
    }
}
