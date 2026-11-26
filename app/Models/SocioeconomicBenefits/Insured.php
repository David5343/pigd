<?php

namespace App\Models\SocioeconomicBenefits;

use App\Models\Catalogs\AffiliationStatus;
use App\Models\Catalogs\County;
use App\Models\Catalogs\Subdependency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Insured extends Model
{
    protected $table = 'insureds';

    protected $fillable = [
        'subdependency_id',
        'rank_id',
        'workplace_county_id',
        'birthplace_county_id',
        'county_id',
        'affiliation_status_id',
        'file_number',
        'employee_number',
        'name',
        'last_name_1',
        'last_name_2',
        'sex',
        'birthday',
        'blood_type',
        'rfc',
        'curp',
        'marital_status',
        'phone',
        'email',
        'neighborhood',
        'roadway_type',
        'street',
        'outdoor_number',
        'interior_number',
        'cp',
        'locality',
        'start_date',
        'register_motive',
        'inactive_date',
        'inactive_date_dependency',
        'inactive_motive',
        'inactive_reference',
        'reentry_date',
        'observations',
        'modified_by',
    ];

    public function subdependency(): BelongsTo
    {
        return $this->belongsTo(Subdependency::class);
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    public function workplaceCounty()
    {
        return $this->belongsTo(County::class, 'workplace_county_id');
    }

    public function birthplaceCounty()
    {
        return $this->belongsTo(County::class, 'birthplace_county_id');
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'county_id');
    }

    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function credencialInsured(): HasMany
    {
        return $this->hasMany(CredentialInsured::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function retiree(): HasMany
    {
        return $this->hasMany(Retiree::class);
    }

    public function affiliationStatus()
    {
        return $this->belongsTo(AffiliationStatus::class);
    }
}
