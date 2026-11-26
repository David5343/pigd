<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Services\MedicalCoordination\BeneficiaryExpedientData;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class BeneficiaryCredentialsModal extends Component
{
    private const CREATE_ROLES = [
        'JefaturaCoordinacion',
        'PrestacionesSocioEconomicas',
        'JefaturaPrestaciones',
        'SuperAdmin',
    ];

    public bool $isOpen = false;

    #[Locked]
    public ?array $expediente = null;

    #[Locked]
    public ?int $beneficiaryId = null;

    #[Locked]
    public bool $canCreateCredential = false;

    #[Locked]
    public bool $showCreateModal = false;

    public ?string $successMessage = null;

    #[On('open-beneficiary-credentials')]
    public function open(int $beneficiaryId): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'JefaturaCoordinacion',
            'PrestacionesSocioEconomicas',
            'JefaturaPrestaciones',
            'SuperAdmin',
        ]), 403);

        $this->expediente = app(BeneficiaryExpedientData::class)->forId($beneficiaryId);
        $this->beneficiaryId = $beneficiaryId;
        $this->canCreateCredential = auth()->user()?->hasAnyRole(self::CREATE_ROLES) ?? false;
        $this->showCreateModal = false;
        $this->successMessage = null;
        $this->isOpen = true;
    }

    public function openCreateCredential(): void
    {
        $this->authorizeCredentialCreation();
        abort_unless($this->isOpen && $this->beneficiaryId, 404);

        $this->successMessage = null;
        $this->showCreateModal = true;
        $this->dispatch('open-beneficiary-credential-create-form', beneficiaryId: $this->beneficiaryId)
            ->to(BeneficiaryCredentialCreateForm::class);
    }

    public function handleEscape(): void
    {
        if ($this->showCreateModal) {
            $this->dispatch('close-beneficiary-credential-create-form')
                ->to(BeneficiaryCredentialCreateForm::class);
            $this->showCreateModal = false;

            return;
        }

        $this->close();
    }

    #[On('beneficiary-credential-created')]
    public function credentialCreated(int $beneficiaryId, string $message): void
    {
        if (! $this->isOpen || $this->beneficiaryId !== $beneficiaryId) {
            return;
        }

        $this->expediente = app(BeneficiaryExpedientData::class)->forId($beneficiaryId);
        $this->successMessage = $message;
        $this->showCreateModal = false;
    }

    #[On('beneficiary-credential-create-closed')]
    public function credentialCreateClosed(): void
    {
        $this->showCreateModal = false;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->expediente = null;
        $this->beneficiaryId = null;
        $this->canCreateCredential = false;
        $this->showCreateModal = false;
        $this->successMessage = null;
    }

    private function authorizeCredentialCreation(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(self::CREATE_ROLES), 403);
    }

    public function render()
    {
        return view('livewire.socioeconomic-benefits.beneficiary-credentials-modal');
    }
}
