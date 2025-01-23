<?php

namespace App\Models\SocioeconomicBenefits;

use App\Models\Catalogs\Bank;
use App\Models\Catalogs\Subdependency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Insured extends Model
{
    protected $table = 'insureds';

    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function subdependency(): BelongsTo
    {
        return $this->belongsTo(Subdependency::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
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
}
