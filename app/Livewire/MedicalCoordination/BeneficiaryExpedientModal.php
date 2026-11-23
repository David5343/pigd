<?php

namespace App\Livewire\MedicalCoordination;

use App\Services\MedicalCoordination\BeneficiaryExpedientData;
use Livewire\Attributes\On;
use Livewire\Component;

class BeneficiaryExpedientModal extends Component
{
    public bool $isOpen = false;

    public ?array $expediente = null;

    #[On('open-medical-beneficiary-expedient')]
    public function open(int $beneficiaryId): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'Enlace',
            'JefaturaCoordinacion',
            'CoordinacionMedica',
            'JefaturaAdministracion',
            'SuperAdmin',
        ]), 403);

        $this->expediente = app(BeneficiaryExpedientData::class)->forId($beneficiaryId);
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->expediente = null;
    }

    public function render()
    {
        return view('livewire.medical-coordination.beneficiary-expedient-modal');
    }
}
