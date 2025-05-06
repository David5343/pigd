<?php

namespace App\Models\HumanResources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeProcedure extends Model
{
    public function employee():BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
