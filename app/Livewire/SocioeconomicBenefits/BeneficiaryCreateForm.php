<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Beneficiary;
use App\Models\SocioeconomicBenefits\Insured;
use Haruncpi\LaravelIdGenerator\IdGenerator;
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

class BeneficiaryCreateForm extends Component
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
    public ?array $selectedInsured = null;

    #[Locked]
    public string $file_number = '';

    public string $insuredSearch = '';

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

    public ?string $createError = null;

    public function mount(): void
    {
        $this->authorizeFamilyCreation();
        $this->resetFamilyForm();
    }

    #[On('open-beneficiary-create-form')]
    public function open(): void
    {
        $this->authorizeFamilyCreation();
        $this->insuredId = null;
        $this->selectedInsured = null;
        $this->insuredSearch = '';
        $this->createError = null;
        $this->resetFamilyForm();
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->insuredId = null;
        $this->selectedInsured = null;
        $this->insuredSearch = '';
        $this->createError = null;
        $this->resetFamilyForm();
    }

    public function selectInsured(int $insuredId): void
    {
        $this->authorizeFamilyCreation();

        $insured = Insured::query()
            ->whereHas('affiliationStatus', fn ($query) => $query->where('name', 'Activo'))
            ->findOrFail($insuredId);

        $this->insuredId = $insured->id;
        $this->selectedInsured = [
            'id' => $insured->id,
            'file_number' => $insured->file_number,
            'name' => collect([$insured->last_name_1, $insured->last_name_2, $insured->name])
                ->filter(fn ($part) => filled($part))
                ->implode(' '),
            'rfc' => $insured->rfc,
        ];
        $this->insuredSearch = '';
        $this->createError = null;
        $this->resetValidation('insuredId');
    }

    public function clearInsuredSelection(): void
    {
        $this->authorizeFamilyCreation();

        $this->insuredId = null;
        $this->selectedInsured = null;
        $this->insuredSearch = '';
        $this->resetFamilyForm();
    }

    public function saveFamily(): void
    {
        $this->authorizeFamilyCreation();
        abort_unless($this->isOpen, 404);
        $this->createError = null;

        if (! $this->insuredId || ! $this->selectedInsured) {
            $this->addError('insuredId', 'Busca y selecciona al titular al que se vinculará el familiar.');

            return;
        }

        if (! Schema::hasColumn('beneficiaries', 'is_student')) {
            $this->createError = 'La base de datos necesita actualizarse antes de registrar familiares.';

            return;
        }

        $validated = $this->validate([
            'file_number' => ['required', 'string', 'max:8', Rule::unique('beneficiaries', 'file_number')],
            'start_date' => ['required', 'date'],
            'last_name_1' => ['required', 'string', 'max:20'],
            'last_name_2' => ['nullable', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:30'],
            'birthday' => ['nullable', 'date'],
            'sex' => ['required', Rule::in(['Hombre', 'Mujer'])],
            'rfc' => ['nullable', 'string', 'max:13', 'alpha_num:ascii'],
            'curp' => ['required', 'string', 'size:18', 'alpha_num:ascii', Rule::unique('beneficiaries', 'curp')],
            'disabled_person' => ['required', Rule::in(['SI', 'NO'])],
            'relationship' => ['required', Rule::in(['Padre', 'Madre', 'Esposa', 'Hijo', 'Hija', 'Concubina'])],
            'is_student' => ['required', Rule::in(['SI', 'NO'])],
            'address' => ['nullable', 'string', 'max:255'],
            'observations' => ['nullable', 'string', 'max:255'],
        ], [
            'file_number.unique' => 'No se pudo reservar el folio generado. Intenta nuevamente.',
            'start_date.required' => 'La fecha de ingreso es obligatoria.',
            'last_name_1.required' => 'El primer apellido es obligatorio.',
            'name.required' => 'El nombre es obligatorio.',
            'sex.required' => 'Selecciona el sexo.',
            'sex.in' => 'El sexo seleccionado no es válido.',
            'disabled_person.required' => 'Indica si el familiar tiene alguna discapacidad.',
            'disabled_person.in' => 'Selecciona SI o NO para discapacidad.',
            'relationship.required' => 'Selecciona el parentesco.',
            'relationship.in' => 'El parentesco seleccionado no es válido.',
            'is_student.in' => 'Selecciona SI o NO para indicar si es estudiante.',
            'curp.required' => 'La CURP es obligatoria.',
            'curp.size' => 'La CURP debe contener exactamente 18 caracteres.',
            'curp.unique' => 'Ya existe un familiar con esa CURP.',
        ], [
            'file_number' => 'folio',
            'start_date' => 'fecha de ingreso',
            'last_name_1' => 'primer apellido',
            'last_name_2' => 'segundo apellido',
            'name' => 'nombre',
            'birthday' => 'fecha de nacimiento',
            'disabled_person' => 'discapacidad',
            'relationship' => 'parentesco',
            'is_student' => 'estudiante',
        ]);

        try {
            $insuredId = $this->insuredId;

            $beneficiary = DB::transaction(function () use ($validated, $insuredId): Beneficiary {
                $insured = Insured::query()->lockForUpdate()->findOrFail($insuredId);

                if (! $insured->affiliationStatus()->where('name', 'Activo')->exists()) {
                    throw ValidationException::withMessages([
                        'insuredId' => 'El titular seleccionado ya no está activo. Selecciónalo nuevamente.',
                    ]);
                }

                if (Beneficiary::query()->where('file_number', $validated['file_number'])->exists()) {
                    throw ValidationException::withMessages([
                        'file_number' => 'El folio generado ya existe. Intenta nuevamente.',
                    ]);
                }

                $this->assertRelationshipIsAvailable($insured->id, $validated['relationship']);
                $this->assertFullNameIsAvailable($insured->id, $validated);

                $beneficiary = new Beneficiary;
                $beneficiary->file_number = $validated['file_number'];
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
                $beneficiary->curp = filled($validated['curp'] ?? null)
                    ? mb_strtoupper(trim($validated['curp']))
                    : null;
                $beneficiary->disabled_person = $validated['disabled_person'];
                $beneficiary->relationship = $validated['relationship'];
                $beneficiary->is_student = $validated['is_student'];
                $beneficiary->address = filled($validated['address'] ?? null)
                    ? trim($validated['address'])
                    : null;
                $beneficiary->observations = filled($validated['observations'] ?? null)
                    ? trim($validated['observations'])
                    : null;
                $beneficiary->insured_id = $insured->id;
                $beneficiary->affiliate_status = 'Activo';
                $beneficiary->status = 'active';
                $beneficiary->modified_by = auth()->user()->email;
                $beneficiary->save();

                return $beneficiary;
            }, 3);

            $message = 'Familiar registrado con folio '.$beneficiary->file_number.'.';
            $this->dispatch('beneficiary-created', message: $message)
                ->to(Beneficiaries::class);
            $this->close();
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (QueryException $exception) {
            Log::error('Error al registrar familiar.', [
                'exception' => $exception::class,
                'sql_state' => $exception->errorInfo[0] ?? null,
            ]);
            $this->createError = 'No se pudo registrar el familiar. Verifica los datos e intenta nuevamente.';
        } catch (Throwable $exception) {
            Log::error('Error inesperado al registrar familiar.', [
                'exception' => $exception::class,
            ]);
            $this->createError = 'Ocurrió un error al registrar el familiar. Intenta nuevamente.';
        }
    }

    private function assertRelationshipIsAvailable(int $insuredId, string $relationship): void
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

    private function assertFullNameIsAvailable(int $insuredId, array $validated): void
    {
        $lastName1 = Str::squish($validated['last_name_1']);
        $lastName2 = Str::squish((string) ($validated['last_name_2'] ?? ''));
        $name = Str::squish($validated['name']);

        $alreadyExists = Beneficiary::query()
            ->where('insured_id', $insuredId)
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

    private function authorizeFamilyCreation(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(self::CREATE_ROLES), 403);
    }

    private function resetFamilyForm(): void
    {
        $this->file_number = IdGenerator::generate([
            'table' => 'beneficiaries',
            'field' => 'file_number',
            'length' => 8,
            'prefix' => 'F',
        ]);
        $this->start_date = now()->toDateString();
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
        $this->resetValidation();
    }

    private function activeInsuredOptions()
    {
        $search = trim($this->insuredSearch);

        if ($this->selectedInsured || mb_strlen($search) < 2) {
            return collect();
        }

        $terms = preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY);

        return Insured::query()
            ->whereHas('affiliationStatus', fn ($query) => $query->where('name', 'Activo'))
            ->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $pattern = "%{$term}%";

                    $query->where(function ($q) use ($pattern) {
                        $q->where('file_number', 'like', $pattern)
                            ->orWhere('name', 'like', $pattern)
                            ->orWhere('last_name_1', 'like', $pattern)
                            ->orWhere('last_name_2', 'like', $pattern)
                            ->orWhere('rfc', 'like', $pattern)
                            ->orWhereRaw("CONCAT(name, ' ', last_name_1, ' ', last_name_2) LIKE ?", [$pattern]);
                    });
                }
            })
            ->orderBy('file_number')
            ->limit(10)
            ->get(['id', 'file_number', 'last_name_1', 'last_name_2', 'name', 'rfc']);
    }

    public function render()
    {
        return view('livewire.socioeconomic-benefits.beneficiary-create-form', [
            'insuredOptions' => $this->activeInsuredOptions(),
        ]);
    }
}
