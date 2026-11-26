<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\CredentialInsured;
use App\Models\SocioeconomicBenefits\Insured;
use App\Services\SocioeconomicBenefits\InsuredCredentialMedia;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class InsuredCredentialCreateForm extends Component
{
    private const CREATE_ROLES = [
        'JefaturaCoordinacion',
        'PrestacionesSocioEconomicas',
        'JefaturaPrestaciones',
        'SuperAdmin',
    ];

    public bool $isOpen = false;

    #[Locked]
    public ?int $insuredId = null;

    #[Locked]
    public ?array $titular = null;

    #[Locked]
    public array $eligibilityIssues = [];

    #[Locked]
    public string $issuedDate = '';

    public string $expiresAt = '';

    public ?string $saveError = null;

    #[On('open-insured-credential-create-form')]
    public function open(int $insuredId): void
    {
        $this->authorizeCredentialIssue();

        $this->insuredId = $insuredId;
        $this->loadTitularState();
        $this->expiresAt = '';
        $this->saveError = null;
        $this->resetValidation();
        $this->isOpen = true;
    }

    #[On('close-insured-credential-create-form')]
    public function close(): void
    {
        $wasOpen = $this->isOpen;
        $this->isOpen = false;
        $this->insuredId = null;
        $this->titular = null;
        $this->eligibilityIssues = [];
        $this->issuedDate = '';
        $this->expiresAt = '';
        $this->saveError = null;
        $this->resetValidation();

        if ($wasOpen) {
            $this->dispatch('credential-create-closed')
                ->to(\App\Livewire\MedicalCoordination\InsuredCredentialsModal::class);
        }
    }

    public function createCredential(): void
    {
        $this->authorizeCredentialIssue();
        abort_unless($this->isOpen && $this->insuredId, 404);
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
            $insuredId = $this->insuredId;

            $credential = DB::transaction(function () use ($insuredId, $validated): CredentialInsured {
                $insured = Insured::query()
                    ->with(['affiliationStatus', 'subdependency.dependency'])
                    ->lockForUpdate()
                    ->findOrFail($insuredId);

                $issues = $this->credentialEligibilityIssues($insured);

                if ($issues !== []) {
                    $this->eligibilityIssues = $issues;

                    throw ValidationException::withMessages([
                        'eligibility' => 'No se puede generar la credencial. Revisa los requisitos pendientes.',
                    ]);
                }

                $credential = new CredentialInsured;
                $credential->issued_at = now()->toDateTimeString();
                $credential->expires_at = Carbon::createFromFormat('Y-m-d', $validated['expiresAt'])
                    ->startOfDay()
                    ->toDateTimeString();
                $credential->insured_id = $insured->id;
                $credential->expiration_types = 'PERSONALIZADO';
                $credential->credential_status = 'VIGENTE';
                $credential->status = 'active';
                $credential->modified_by = auth()->user()->email;
                $credential->save();

                return $credential;
            }, 3);

            $this->dispatch(
                'credential-created',
                insuredId: $insuredId,
                message: 'La credencial se registró correctamente con vigencia hasta '.Carbon::parse($credential->expires_at)->format('d/m/Y').'.'
            )->to(\App\Livewire\MedicalCoordination\InsuredCredentialsModal::class);
            $this->close();
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (QueryException $exception) {
            Log::error('Error al registrar credencial de titular.', [
                'exception' => $exception::class,
                'sql_state' => $exception->errorInfo[0] ?? null,
            ]);
            $this->saveError = 'No se pudo registrar la credencial. Intenta nuevamente.';
        } catch (Throwable $exception) {
            Log::error('Error inesperado al registrar credencial de titular.', [
                'exception' => $exception::class,
            ]);
            $this->saveError = 'Ocurrió un error al registrar la credencial. Intenta nuevamente.';
        }
    }

    private function loadTitularState(): void
    {
        $insured = Insured::with(['affiliationStatus', 'subdependency.dependency'])
            ->findOrFail($this->insuredId);

        $this->titular = [
            'id' => $insured->id,
            'name' => collect([$insured->last_name_1, $insured->last_name_2, $insured->name])
                ->filter(fn ($part) => filled($part))
                ->implode(' '),
            'file_number' => $insured->file_number,
            'affiliation_status' => $insured->affiliationStatus?->name,
        ];
        $this->issuedDate = now()->toDateString();
        $this->eligibilityIssues = $this->credentialEligibilityIssues($insured);
    }

    private function credentialEligibilityIssues(Insured $insured): array
    {
        $issues = [];

        if ($insured->affiliationStatus?->name !== 'Activo') {
            $issues[] = 'El titular debe tener estatus de afiliación Activo.';
        }

        foreach ([
            'Falta el folio de afiliación del titular.' => $insured->file_number,
            'Falta el RFC del titular.' => $insured->rfc,
            'Falta la CURP del titular.' => $insured->curp,
            'Falta la dependencia de adscripción del titular.' => $insured->subdependency?->dependency?->name,
            'Falta el tipo de sangre del titular.' => $insured->blood_type,
            'Falta el nombre del titular.' => $insured->name,
        ] as $message => $value) {
            if (blank($value)) {
                $issues[] = $message;
            }
        }

        if (blank($insured->last_name_1) && blank($insured->last_name_2)) {
            $issues[] = 'Debe existir al menos uno de los apellidos del titular.';
        }

        $media = app(InsuredCredentialMedia::class);

        if (blank($insured->photo)) {
            $issues[] = 'Falta la fotografía del titular.';
        } elseif (! $media->hasPhoto($insured)) {
            $issues[] = 'No se encontró el archivo de fotografía del titular.';
        }

        if (blank($insured->signature)) {
            $issues[] = 'Falta la firma del titular.';
        } elseif (! $media->hasSignature($insured)) {
            $issues[] = 'No se encontró el archivo de firma del titular.';
        }

        if (
            $insured->id
            && CredentialInsured::query()
                ->where('insured_id', $insured->id)
                ->where('credential_status', 'VIGENTE')
                ->exists()
        ) {
            $issues[] = 'El titular ya cuenta con una credencial vigente.';
        }

        return $issues;
    }

    private function authorizeCredentialIssue(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(self::CREATE_ROLES), 403);
    }

    public function render()
    {
        return view('livewire.socioeconomic-benefits.insured-credential-create-form');
    }
}
