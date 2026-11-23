<?php

namespace App\Livewire\MedicalCoordination;

use App\Services\MedicalCoordination\InsuredExpedientData;
use Livewire\Attributes\On;
use Livewire\Component;

class InsuredFamiliesModal extends Component
{
    public bool $isOpen = false;

    public ?array $expediente = null;

    #[On('open-medical-insured-families')]
    public function open(int $insuredId): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'Enlace',
            'JefaturaCoordinacion',
            'CoordinacionMedica',
            'JefaturaAdministracion',
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
        return view('livewire.medical-coordination.insured-families-modal');
    }
}
