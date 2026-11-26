<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Services\MedicalCoordination\InsuredExpedientData;
use Livewire\Attributes\On;
use Livewire\Component;

class InsuredFamiliesModal extends Component
{
    public bool $isOpen = false;

    public ?array $expediente = null;

    #[On('open-socioeconomic-insured-families')]
    public function open(int $insuredId): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'JefaturaCoordinacion',
            'PrestacionesSocioEconomicas',
            'JefaturaPrestaciones',
            'SuperAdmin',
        ]), 403);

        $this->expediente = app(InsuredExpedientData::class)->familiaresForId($insuredId);
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->expediente = null;
    }

    public function render()
    {
        return view('livewire.socioeconomic-benefits.insured-families-modal');
    }
}
