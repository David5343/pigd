<?php

namespace App\Models\Catalogs;

use App\Models\HumanResources\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Degree extends Model
{
    use SoftDeletes;

    public function employees():HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
