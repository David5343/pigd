<?php

namespace App\Models\SocioeconomicBenefits;

use App\Models\Catalogs\County;
use App\Models\Catalogs\PensionType;
use App\Models\Catalogs\Subdependency;
use App\Models\Catalogs\WorkRisk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pensioner extends Model
{
    public function subdependency(): BelongsTo
    {
        return $this->belongsTo(Subdependency::class);
    }
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class, 'county_id');
    }
        public function pensionType(): BelongsTo
    {
        return $this->belongsTo(PensionType::class, 'pension_types_id');
    }
        public function workRisks(): BelongsTo
    {
        return $this->belongsTo(WorkRisk::class);
    }
    public function beneficiaries(): HasMany
    {
        return $this->hasMany(PensionerBeneficiary::class);
    }
}
