<?php

namespace App\Livewire\MedicalCoordination;

use App\Services\MedicalCoordination\InsuredExpedientData;
use Livewire\Attributes\On;
use Livewire\Component;

class InsuredExpedientModal extends Component
{
    public bool $isOpen = false;

    public ?array $expediente = null;

    #[On('open-medical-insured-expedient')]
    public function open(int $insuredId, string $origin = 'medical'): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'Enlace',
            'JefaturaCoordinacion',
            'CoordinacionMedica',
            'JefaturaAdministracion',
            'PrestacionesSocioEconomicas',
            'JefaturaPrestaciones',
            'SuperAdmin',
        ]), 403);

        $this->expediente = app(InsuredExpedientData::class)->forId($insuredId);
        $this->expediente['beneficiaryExpedientOrigin'] = $origin === 'socioeconomic'
            ? 'socioeconomic'
            : 'medical';
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->expediente = null;
    }

    public function render()
    {
        return view('livewire.medical-coordination.insured-expedient-modal');
    }
}
