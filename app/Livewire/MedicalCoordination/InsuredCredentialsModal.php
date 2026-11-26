<?php

namespace App\Livewire\MedicalCoordination;

use App\Livewire\SocioeconomicBenefits\InsuredCredentialCreateForm;
use App\Services\MedicalCoordination\InsuredExpedientData;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class InsuredCredentialsModal extends Component
{
    private const CREATE_ROLES = [
        'JefaturaCoordinacion',
        'PrestacionesSocioEconomicas',
        'JefaturaPrestaciones',
        'SuperAdmin',
    ];

    public bool $isOpen = false;

    public ?array $expediente = null;

    #[Locked]
    public ?int $insuredId = null;

    #[Locked]
    public bool $canCreateCredential = false;

    #[Locked]
    public bool $showCreateCredentialModal = false;

    public ?string $successMessage = null;

    #[On('open-medical-insured-credentials')]
    public function open(int $insuredId): void
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

        $this->expediente = app(InsuredExpedientData::class)->credencialesForId($insuredId);
        $this->insuredId = $insuredId;
        $this->canCreateCredential = auth()->user()?->hasAnyRole(self::CREATE_ROLES) ?? false;
        $this->showCreateCredentialModal = false;
        $this->successMessage = null;
        $this->isOpen = true;
    }

    public function openCreateCredential(): void
    {
        $this->authorizeCredentialIssue();
        abort_unless($this->isOpen && $this->insuredId, 404);

        $this->successMessage = null;
        $this->showCreateCredentialModal = true;
        $this->dispatch('open-insured-credential-create-form', insuredId: $this->insuredId)
            ->to(InsuredCredentialCreateForm::class);
    }

    public function handleEscape(): void
    {
        if ($this->showCreateCredentialModal) {
            $this->dispatch('close-insured-credential-create-form')
                ->to(InsuredCredentialCreateForm::class);
            $this->showCreateCredentialModal = false;

            return;
        }

        $this->close();
    }

    #[On('credential-created')]
    public function credentialCreated(int $insuredId, string $message): void
    {
        if (! $this->isOpen || $this->insuredId !== $insuredId) {
            return;
        }

        $this->expediente = app(InsuredExpedientData::class)->credencialesForId($insuredId);
        $this->successMessage = $message;
        $this->showCreateCredentialModal = false;
    }

    #[On('credential-create-closed')]
    public function credentialCreateClosed(): void
    {
        $this->showCreateCredentialModal = false;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->expediente = null;
        $this->insuredId = null;
        $this->canCreateCredential = false;
        $this->showCreateCredentialModal = false;
        $this->successMessage = null;
    }

    private function authorizeCredentialIssue(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(self::CREATE_ROLES), 403);
    }

    public function render()
    {
        return view('livewire.medical-coordination.insured-credentials-modal');
    }
}
