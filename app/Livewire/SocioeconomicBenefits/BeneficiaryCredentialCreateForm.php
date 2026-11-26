<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Beneficiary;
use App\Models\SocioeconomicBenefits\CredentialBeneficiary;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class BeneficiaryCredentialCreateForm extends Component
{
    private const CREATE_ROLES = [
        'JefaturaCoordinacion',
        'PrestacionesSocioEconomicas',
        'JefaturaPrestaciones',
        'SuperAdmin',
    ];

    public bool $isOpen = false;

    #[Locked]
    public ?int $beneficiaryId = null;

    #[Locked]
    public ?array $familiar = null;

    #[Locked]
    public array $eligibilityIssues = [];

    #[Locked]
    public string $issuedDate = '';

    public string $expiresAt = '';

    public ?string $saveError = null;

    #[On('open-beneficiary-credential-create-form')]
    public function open(int $beneficiaryId): void
    {
        $this->authorizeCredentialCreation();

        $beneficiary = Beneficiary::findOrFail($beneficiaryId);
        $this->beneficiaryId = $beneficiary->id;
        $this->familiar = [
            'name' => collect([$beneficiary->last_name_1, $beneficiary->last_name_2, $beneficiary->name])
                ->filter(fn ($part) => filled($part))
                ->implode(' '),
            'file_number' => $beneficiary->file_number,
            'affiliate_status' => $beneficiary->affiliate_status,
        ];
        $this->eligibilityIssues = $this->credentialEligibilityIssues($beneficiary->id);
        $this->issuedDate = now()->toDateString();
        $this->expiresAt = '';
        $this->saveError = null;
        $this->resetValidation();
        $this->isOpen = true;
    }

    #[On('close-beneficiary-credential-create-form')]
    public function close(): void
    {
        $wasOpen = $this->isOpen;
        $this->isOpen = false;
        $this->beneficiaryId = null;
        $this->familiar = null;
        $this->eligibilityIssues = [];
        $this->issuedDate = '';
        $this->expiresAt = '';
        $this->saveError = null;
        $this->resetValidation();

        if ($wasOpen) {
            $this->dispatch('beneficiary-credential-create-closed')
                ->to(BeneficiaryCredentialsModal::class);
        }
    }

    public function createCredential(): void
    {
        $this->authorizeCredentialCreation();
        abort_unless($this->isOpen && $this->beneficiaryId, 404);
        $this->saveError = null;

        $validated = $this->validate([
            'expiresAt' => ['required', 'date_format:Y-m-d'],
        ], [
            'expiresAt.required' => 'Selecciona la fecha de vigencia.',
            'expiresAt.date_format' => 'La fecha de vigencia no es válida.',
        ], [
            'expiresAt' => 'fecha de vigencia',
        ]);

        try {
            $beneficiaryId = $this->beneficiaryId;

            $credential = DB::transaction(function () use ($beneficiaryId, $validated): CredentialBeneficiary {
                $beneficiary = Beneficiary::query()->lockForUpdate()->findOrFail($beneficiaryId);

                if (
                    CredentialBeneficiary::query()
                        ->where('beneficiary_id', $beneficiary->id)
                        ->where('credential_status', 'VIGENTE')
                        ->exists()
                ) {
                    $this->eligibilityIssues = [
                        'Este familiar ya cuenta con una credencial vigente.',
                    ];

                    throw ValidationException::withMessages([
                        'credential' => 'Este familiar ya cuenta con una credencial vigente.',
                    ]);
                }

                $credential = new CredentialBeneficiary;
                $credential->issued_at = now()->toDateTimeString();
                $credential->expires_at = Carbon::createFromFormat('Y-m-d', $validated['expiresAt'])
                    ->startOfDay()
                    ->toDateTimeString();
                $credential->beneficiary_id = $beneficiary->id;
                $credential->expiration_types = 'PERSONALIZADO';
                $credential->credential_status = 'VIGENTE';
                $credential->status = 'active';
                $credential->modified_by = auth()->user()->email;
                $credential->save();

                return $credential;
            }, 3);

            $this->dispatch(
                'beneficiary-credential-created',
                beneficiaryId: $beneficiaryId,
                message: 'La credencial del familiar se registró correctamente con vigencia hasta '
                    .Carbon::parse($credential->expires_at)->format('d/m/Y').'.'
            )->to(BeneficiaryCredentialsModal::class);
            $this->close();
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (QueryException $exception) {
            Log::error('Error al registrar credencial de familiar.', [
                'exception' => $exception::class,
                'sql_state' => $exception->errorInfo[0] ?? null,
            ]);
            $this->saveError = 'No se pudo registrar la credencial. Intenta nuevamente.';
        } catch (Throwable $exception) {
            Log::error('Error inesperado al registrar credencial de familiar.', [
                'exception' => $exception::class,
            ]);
            $this->saveError = 'Ocurrió un error al registrar la credencial. Intenta nuevamente.';
        }
    }

    private function authorizeCredentialCreation(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(self::CREATE_ROLES), 403);
    }

    private function credentialEligibilityIssues(int $beneficiaryId): array
    {
        return CredentialBeneficiary::query()
            ->where('beneficiary_id', $beneficiaryId)
            ->where('credential_status', 'VIGENTE')
            ->exists()
                ? ['Este familiar ya cuenta con una credencial vigente.']
                : [];
    }

    public function render()
    {
        return view('livewire.socioeconomic-benefits.beneficiary-credential-create-form');
    }
}
