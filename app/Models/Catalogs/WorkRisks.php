<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkRisks extends Model
{
    public function pensionType(): BelongsTo
    {
        return $this->belongsTo(PensionType::class);
    }
}
