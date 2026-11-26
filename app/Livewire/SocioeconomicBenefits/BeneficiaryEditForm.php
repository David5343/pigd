<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Beneficiary;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class BeneficiaryEditForm extends Component
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
    public ?int $insuredId = null;

    #[Locked]
    public ?array $selectedInsured = null;

    #[Locked]
    public string $file_number = '';

    #[Locked]
    public string $affiliate_status = '';

    public string $start_date = '';

    public string $last_name_1 = '';

    public string $last_name_2 = '';

    public string $name = '';

    public string $birthday = '';

    public string $sex = '';

    public string $rfc = '';

    public string $curp = '';

    public string $disabled_person = '';

    public string $relationship = '';

    public string $is_student = 'NO';

    public string $address = '';

    public string $observations = '';

    public ?string $saveError = null;

    #[On('open-beneficiary-edit-form')]
    public function open(int $beneficiaryId): void
    {
        $this->authorizeFamilyEdit();

        $beneficiary = Beneficiary::query()
            ->where('affiliate_status', 'Activo')
            ->where('status', 'active')
            ->with('insured')
            ->findOrFail($beneficiaryId);

        $this->beneficiaryId = $beneficiary->id;
        $this->insuredId = $beneficiary->insured_id;
        $this->selectedInsured = $beneficiary->insured ? [
            'name' => collect([
                $beneficiary->insured->last_name_1,
                $beneficiary->insured->last_name_2,
                $beneficiary->insured->name,
            ])->filter(fn ($part) => filled($part))->implode(' '),
            'file_number' => $beneficiary->insured->file_number,
        ] : null;
        $this->file_number = $beneficiary->file_number ?? '';
        $this->affiliate_status = $beneficiary->affiliate_status ?? '';
        $this->start_date = $beneficiary->start_date ?? '';
        $this->last_name_1 = $beneficiary->last_name_1 ?? '';
        $this->last_name_2 = $beneficiary->last_name_2 ?? '';
        $this->name = $beneficiary->name ?? '';
        $this->birthday = $beneficiary->birthday ?? '';
        $this->sex = $beneficiary->sex ?? '';
        $this->rfc = $beneficiary->rfc ?? '';
        $this->curp = $beneficiary->curp ?? '';
        $this->disabled_person = $beneficiary->disabled_person ?? '';
        $this->relationship = $beneficiary->relationship ?? '';
        $this->is_student = $beneficiary->is_student ?? 'NO';
        $this->address = $beneficiary->address ?? '';
        $this->observations = $beneficiary->observations ?? '';
        $this->saveError = null;
        $this->resetValidation();
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->beneficiaryId = null;
        $this->insuredId = null;
        $this->selectedInsured = null;
        $this->file_number = '';
        $this->affiliate_status = '';
        $this->start_date = '';
        $this->last_name_1 = '';
        $this->last_name_2 = '';
        $this->name = '';
        $this->birthday = '';
        $this->sex = '';
        $this->rfc = '';
        $this->curp = '';
        $this->disabled_person = '';
        $this->relationship = '';
        $this->is_student = 'NO';
        $this->address = '';
        $this->observations = '';
        $this->saveError = null;
        $this->resetValidation();
    }

    public function saveChanges(): void
    {
        $this->authorizeFamilyEdit();
        abort_unless($this->isOpen && $this->beneficiaryId && $this->insuredId, 404);
        $this->saveError = null;

        if (! Schema::hasColumn('beneficiaries', 'is_student')) {
            $this->saveError = 'La base de datos necesita actualizarse antes de editar familiares.';

            return;
        }

        $validated = $this->validate([
            'start_date' => ['required', 'date'],
            'last_name_1' => ['required', 'string', 'max:20'],
            'last_name_2' => ['nullable', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:30'],
            'birthday' => ['nullable', 'date'],
            'sex' => ['required', Rule::in(['Hombre', 'Mujer'])],
            'rfc' => ['nullable', 'string', 'max:13', 'alpha_num:ascii'],
            'curp' => [
                'required',
                'string',
                'size:18',
                'alpha_num:ascii',
                Rule::unique('beneficiaries', 'curp')->ignore($this->beneficiaryId),
            ],
            'disabled_person' => ['required', Rule::in(['SI', 'NO'])],
            'relationship' => ['required', Rule::in(['Padre', 'Madre', 'Esposa', 'Hijo', 'Hija', 'Concubina'])],
            'is_student' => ['required', Rule::in(['SI', 'NO'])],
            'address' => ['nullable', 'string', 'max:255'],
            'observations' => ['nullable', 'string', 'max:255'],
        ], [
            'start_date.required' => 'La fecha de ingreso es obligatoria.',
            'last_name_1.required' => 'El primer apellido es obligatorio.',
            'name.required' => 'El nombre es obligatorio.',
            'sex.required' => 'Selecciona el sexo.',
            'sex.in' => 'El sexo seleccionado no es válido.',
            'curp.required' => 'La CURP es obligatoria.',
            'curp.size' => 'La CURP debe contener exactamente 18 caracteres.',
            'curp.unique' => 'Ya existe un familiar con esa CURP.',
            'disabled_person.required' => 'Indica si el familiar tiene alguna discapacidad.',
            'relationship.required' => 'Selecciona el parentesco.',
            'relationship.in' => 'El parentesco seleccionado no es válido.',
            'is_student.in' => 'Selecciona SI o NO para indicar si es estudiante.',
        ], [
            'start_date' => 'fecha de ingreso',
            'last_name_1' => 'primer apellido',
            'last_name_2' => 'segundo apellido',
            'name' => 'nombre',
            'birthday' => 'fecha de nacimiento',
            'curp' => 'CURP',
            'disabled_person' => 'discapacidad',
            'relationship' => 'parentesco',
            'is_student' => 'estudiante',
        ]);

        try {
            $beneficiaryId = $this->beneficiaryId;
            $insuredId = $this->insuredId;

            $beneficiary = DB::transaction(function () use ($validated, $beneficiaryId, $insuredId): Beneficiary {
                $beneficiary = Beneficiary::query()
                    ->where('affiliate_status', 'Activo')
                    ->where('status', 'active')
                    ->lockForUpdate()
                    ->findOrFail($beneficiaryId);

                if ((int) $beneficiary->insured_id !== $insuredId) {
                    abort(404);
                }

                $this->assertRelationshipIsAvailable(
                    $insuredId,
                    $validated['relationship'],
                    $beneficiaryId
                );
                $this->assertFullNameIsAvailable($insuredId, $validated, $beneficiaryId);

                $beneficiary->start_date = $validated['start_date'];
                $beneficiary->last_name_1 = Str::squish($validated['last_name_1']);
                $beneficiary->last_name_2 = filled($validated['last_name_2'] ?? null)
                    ? Str::squish($validated['last_name_2'])
                    : null;
                $beneficiary->name = Str::squish($validated['name']);
                $beneficiary->birthday = filled($validated['birthday'] ?? null)
                    ? $validated['birthday']
                    : null;
                $beneficiary->sex = $validated['sex'];
                $beneficiary->rfc = filled($validated['rfc'] ?? null)
                    ? mb_strtoupper(trim($validated['rfc']))
                    : null;
                $beneficiary->curp = mb_strtoupper(trim($validated['curp']));
                $beneficiary->disabled_person = $validated['disabled_person'];
                $beneficiary->relationship = $validated['relationship'];
                $beneficiary->is_student = $validated['is_student'];
                $beneficiary->address = filled($validated['address'] ?? null)
                    ? trim($validated['address'])
                    : null;
                $beneficiary->observations = filled($validated['observations'] ?? null)
                    ? trim($validated['observations'])
                    : null;
                $beneficiary->modified_by = auth()->user()->email;
                $beneficiary->save();

                return $beneficiary;
            }, 3);

            $this->dispatch(
                'beneficiary-updated',
                message: 'Los datos del familiar '.$beneficiary->file_number.' se actualizaron correctamente.'
            )->to(Beneficiaries::class);
            $this->close();
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (QueryException $exception) {
            Log::error('Error al editar familiar.', [
                'exception' => $exception::class,
                'sql_state' => $exception->errorInfo[0] ?? null,
            ]);
            $this->saveError = 'No se pudieron guardar los cambios. Verifica los datos e intenta nuevamente.';
        } catch (Throwable $exception) {
            Log::error('Error inesperado al editar familiar.', [
                'exception' => $exception::class,
            ]);
            $this->saveError = 'Ocurrió un error al guardar los cambios. Intenta nuevamente.';
        }
    }

    private function assertRelationshipIsAvailable(int $insuredId, string $relationship, int $exceptId): void
    {
        $existingRelationships = match ($relationship) {
            'Padre', 'Madre' => [$relationship],
            'Esposa', 'Concubina' => ['Esposa', 'Concubina'],
            default => [],
        };

        if ($existingRelationships === []) {
            return;
        }

        $alreadyExists = Beneficiary::query()
            ->where('insured_id', $insuredId)
            ->where('affiliate_status', 'Activo')
            ->whereIn('relationship', $existingRelationships)
            ->where('id', '<>', $exceptId)
            ->exists();

        if ($alreadyExists) {
            $message = match ($relationship) {
                'Padre' => 'Este titular ya tiene un padre registrado.',
                'Madre' => 'Este titular ya tiene una madre registrada.',
                default => 'Este titular ya tiene registrada una esposa o concubina.',
            };

            throw ValidationException::withMessages(['relationship' => $message]);
        }
    }

    private function assertFullNameIsAvailable(int $insuredId, array $validated, int $exceptId): void
    {
        $lastName1 = Str::squish($validated['last_name_1']);
        $lastName2 = Str::squish((string) ($validated['last_name_2'] ?? ''));
        $name = Str::squish($validated['name']);

        $alreadyExists = Beneficiary::query()
            ->where('insured_id', $insuredId)
            ->where('id', '<>', $exceptId)
            ->whereRaw("LOWER(TRIM(COALESCE(last_name_1, ''))) = LOWER(?)", [$lastName1])
            ->whereRaw("LOWER(TRIM(COALESCE(last_name_2, ''))) = LOWER(?)", [$lastName2])
            ->whereRaw("LOWER(TRIM(COALESCE(name, ''))) = LOWER(?)", [$name])
            ->exists();

        if ($alreadyExists) {
            throw ValidationException::withMessages([
                'name' => 'Ya existe un familiar con ese nombre completo vinculado a este titular.',
            ]);
        }
    }

    private function authorizeFamilyEdit(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(self::CREATE_ROLES), 403);
    }

    public function render()
    {
        return view('livewire.socioeconomic-benefits.beneficiary-edit-form');
    }
}
