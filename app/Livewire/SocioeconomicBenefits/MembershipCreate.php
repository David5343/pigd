<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\Catalogs\AffiliationStatus;
use App\Models\Catalogs\County;
use App\Models\Catalogs\Dependency;
use App\Models\Catalogs\State;
use App\Models\Catalogs\Subdependency;
use App\Models\SocioeconomicBenefits\Insured;
use App\Models\SocioeconomicBenefits\Rank;
use App\Services\SocioeconomicBenefits\InsuredFileNumberAllocator;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;
use RuntimeException;
use Throwable;

class MembershipCreate extends Component
{
    public bool $inModal = false;

    #[Validate('required|exists:dependencies,id')]
    public $dependency_id;

    #[Validate('required|exists:subdependencies,id')]
    public $subdependency_id;

    #[Validate('required|exists:ranks,id')]
    public $rank_id;

    #[Validate('required|digits_between:1,6')]
    public $employee_number;

    #[Validate('required|date|after_or_equal:1980-01-01')]
    public $start_date;

    #[Validate('nullable|exists:counties,id')]
    public $workplace_county_id;

    public $workplace_state_id;

    #[Validate('nullable|min:3|max:120')]
    public $register_motive;

    #[Validate('required|exists:affiliation_statuses,id')]
    public $affiliation_status_id = 1;

    #[Validate('nullable|min:5|max:180')]
    public $observations;

    public bool $sin_apellido_paterno = false;

    public $last_name_1;

    public bool $sin_apellido_materno = false;

    public $last_name_2;

    #[Validate('required|min:2|max:30')]
    public $name;

    #[Validate('required')]
    public $blood_type;

    #[Validate('required|date_format:Y-m-d')]
    public $birthday;

    #[Validate('nullable|exists:counties,id')]
    public $birthplace_county_id;

    public $birthplace_state_id;

    #[Validate('required')]
    public $sex;

    #[Validate('nullable')]
    public $marital_status;

    #[Validate('required|size:13|alpha_num:ascii')]
    public $rfc;

    #[Validate('nullable|size:18|alpha_num:ascii')]
    public $curp;

    #[Validate('nullable|numeric|digits:10')]
    public $phone;

    #[Validate('nullable|email|min:5|max:50')]
    public $email;

    public $state_id;

    #[Validate('nullable|exists:counties,id')]
    public $county_id;

    #[Validate('nullable|min:5|max:50')]
    public $neighborhood;

    #[Validate('nullable|min:5|max:50')]
    public $roadway_type;

    #[Validate('nullable|min:5|max:50')]
    public $street;

    #[Validate('nullable|max:7')]
    public $outdoor_number;

    #[Validate('nullable|max:7')]
    public $interior_number;

    #[Validate('nullable|numeric|digits:5')]
    public $cp;

    #[Validate('nullable|min:5|max:85')]
    public $locality;

    public function mount(bool $inModal = false): void
    {
        $this->inModal = $inModal;
        $this->affiliation_status_id = 1;
    }

    protected function validationAttributes(): array
    {
        return [
            'dependency_id' => 'dependencia',
            'subdependency_id' => 'subdependencia',
            'rank_id' => 'categoría',
            'employee_number' => 'número de empleado',
            'start_date' => 'fecha de ingreso',
            'workplace_county_id' => 'municipio del lugar de trabajo',
            'register_motive' => 'motivo de alta',
            'affiliation_status_id' => 'estatus de afiliación',
            'observations' => 'observaciones',
            'last_name_1' => 'apellido paterno',
            'last_name_2' => 'apellido materno',
            'name' => 'nombre',
            'blood_type' => 'tipo de sangre',
            'birthday' => 'fecha de nacimiento',
            'birthplace_county_id' => 'municipio de nacimiento',
            'sex' => 'sexo',
            'marital_status' => 'estado civil',
            'rfc' => 'RFC',
            'curp' => 'CURP',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
            'county_id' => 'municipio del domicilio',
            'neighborhood' => 'colonia',
            'roadway_type' => 'tipo de vialidad',
            'street' => 'calle',
            'outdoor_number' => 'número exterior',
            'interior_number' => 'número interior',
            'cp' => 'código postal',
            'locality' => 'localidad',
        ];
    }

    public function updated($property): void
    {
        $surnameByNoSurnameFlag = [
            'sin_apellido_paterno' => 'last_name_1',
            'sin_apellido_materno' => 'last_name_2',
        ];

        if (isset($surnameByNoSurnameFlag[$property]) && $this->{$property}) {
            $surnameProperty = $surnameByNoSurnameFlag[$property];
            $this->{$surnameProperty} = null;
            $this->resetValidation($surnameProperty);
        }

        $countyByState = [
            'dependency_id' => 'subdependency_id',
            'state_id' => 'county_id',
            'workplace_state_id' => 'workplace_county_id',
            'birthplace_state_id' => 'birthplace_county_id',
        ];

        if (isset($countyByState[$property])) {
            $countyProperty = $countyByState[$property];
            $this->{$countyProperty} = null;
            $this->resetValidation($countyProperty);
        }
    }

    public function guardar()
    {
        try {
            DB::beginTransaction();
            $this->validate();
            $this->validateSurnames();
            $this->validateNoDuplicateFullName();
            $this->validateUniqueIdentityFields();
            $this->validateAdultBirthDate();
            $this->validateSubdependencySelection();
            $this->validateAffiliationStatusSelection();
            $this->validateCountySelections();

            $fileNumberAllocator = app(InsuredFileNumberAllocator::class);
            $fileNumber = $fileNumberAllocator->reserve('web');

            if (! $fileNumberAllocator->consume($fileNumber, 'web')) {
                throw new RuntimeException('No se pudo reservar el folio generado. Intenta guardar nuevamente.');
            }

            $titular = new Insured;
            $titular->file_number = $fileNumber;
            $titular->subdependency_id = $this->subdependency_id;
            $titular->rank_id = $this->rank_id;
            $titular->employee_number = filled($this->employee_number)
                ? Str::of($this->employee_number)->trim()
                : null;
            $titular->start_date = $this->start_date;
            $titular->workplace_county_id = $this->workplace_county_id ?: null;
            $titular->register_motive = $this->nullableTrim($this->register_motive);
            $titular->affiliation_status_id = $this->affiliation_status_id;
            $titular->observations = $this->nullableTrim($this->observations);
            $titular->last_name_1 = $this->sin_apellido_paterno
                ? null
                : $this->nullableTrim($this->last_name_1);
            $titular->last_name_2 = $this->sin_apellido_materno
                ? null
                : $this->nullableTrim($this->last_name_2);
            $titular->name = Str::of($this->name)->trim();
            $titular->blood_type = Str::of($this->blood_type)->trim();
            $titular->birthday = $this->birthday;
            $titular->birthplace_county_id = $this->birthplace_county_id ?: null;
            $titular->sex = $this->sex;
            $titular->marital_status = $this->nullableTrim($this->marital_status);
            $rfc = Str::of($this->rfc)->trim();
            $titular->rfc = Str::upper($rfc);
            $curp = $this->nullableTrim($this->curp);
            $titular->curp = $curp !== null ? Str::upper($curp) : null;
            $titular->phone = $this->nullableTrim($this->phone);
            $email = $this->nullableTrim($this->email);
            $titular->email = $email !== null ? Str::lower($email) : null;
            $titular->county_id = $this->county_id ?: null;
            $titular->neighborhood = $this->nullableTrim($this->neighborhood);
            $titular->roadway_type = $this->nullableTrim($this->roadway_type);
            $titular->street = $this->nullableTrim($this->street);
            $titular->outdoor_number = $this->nullableTrim($this->outdoor_number);
            $titular->interior_number = $this->nullableTrim($this->interior_number);
            $titular->cp = $this->nullableTrim($this->cp);
            $titular->locality = $this->nullableTrim($this->locality);
            $titular->status = 'active';
            $titular->modified_by = Auth::user()->email;
            $titular->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch(
                'insured-created',
                message: 'Registro con No. de Expediente: '.$titular->file_number.' creado con éxito!'
            );
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Error en la consulta SQL: '.$e->getMessage());
            session()->flash('msg_warning', 'Error en la base de datos. Contacte al administrador.');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error inesperado: '.$e->getMessage());
            session()->flash('msg_warning', 'Ocurrió un error inesperado. Contacte al administrador.');
        }
    }

    public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function cerrarModal(): void
    {
        $this->dispatch('close-membership-modal');
    }

    protected function validateCountySelections(): void
    {
        $countySelections = [
            'county_id' => [$this->county_id, $this->state_id],
            'workplace_county_id' => [$this->workplace_county_id, $this->workplace_state_id],
            'birthplace_county_id' => [$this->birthplace_county_id, $this->birthplace_state_id],
        ];

        foreach ($countySelections as $field => [$countyId, $stateId]) {
            if (
                filled($countyId)
                && (! filled($stateId) || ! County::query()
                    ->whereKey($countyId)
                    ->where('state_id', $stateId)
                    ->where('status', 'active')
                    ->exists())
            ) {
                throw ValidationException::withMessages([
                    $field => 'Selecciona un municipio válido para la entidad federativa elegida.',
                ]);
            }
        }
    }

    protected function validateSurnames(): void
    {
        $surnames = [
            'last_name_1' => [$this->last_name_1, $this->sin_apellido_paterno],
            'last_name_2' => [$this->last_name_2, $this->sin_apellido_materno],
        ];

        foreach ($surnames as $field => [$surname, $isMissing]) {
            if ($isMissing) {
                continue;
            }

            $length = mb_strlen(trim((string) $surname));

            if ($length < 2 || $length > 20) {
                throw ValidationException::withMessages([
                    $field => $length === 0
                        ? 'Indica el apellido o marca la opción «Sin apellido».'
                        : 'El apellido debe tener entre 2 y 20 caracteres.',
                ]);
            }
        }
    }

    protected function validateNoDuplicateFullName(?int $ignoreInsuredId = null, ?array $originalValues = null): void
    {
        $name = $this->normalizeNamePart($this->name);
        $lastName1 = $this->sin_apellido_paterno
            ? ''
            : $this->normalizeNamePart($this->last_name_1);
        $lastName2 = $this->sin_apellido_materno
            ? ''
            : $this->normalizeNamePart($this->last_name_2);

        if ($ignoreInsuredId && $originalValues !== null) {
            $sameAsOriginal = $name === $this->normalizeNamePart($originalValues['name'] ?? null)
                && $lastName1 === $this->normalizeNamePart($originalValues['last_name_1'] ?? null)
                && $lastName2 === $this->normalizeNamePart($originalValues['last_name_2'] ?? null);

            if ($sameAsOriginal) {
                return;
            }
        }

        $duplicateExists = DB::table('insureds')
            ->whereRaw("LOWER(TRIM(COALESCE(name, ''))) = LOWER(?)", [$name])
            ->whereRaw("LOWER(TRIM(COALESCE(last_name_1, ''))) = LOWER(?)", [$lastName1])
            ->whereRaw("LOWER(TRIM(COALESCE(last_name_2, ''))) = LOWER(?)", [$lastName2])
            ->when($ignoreInsuredId, fn ($query) => $query->where('id', '<>', $ignoreInsuredId))
            ->exists();

        if ($duplicateExists) {
            throw ValidationException::withMessages([
                'name' => 'Ya existe un titular con el mismo nombre y apellidos.',
            ]);
        }
    }

    private function normalizeNamePart(?string $value): string
    {
        return preg_replace('/\s+/u', ' ', trim((string) $value)) ?? '';
    }

    protected function nullableTrim(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        return (string) Str::of($value)->trim();
    }

    protected function validateAdultBirthDate(): void
    {
        $birthDate = Carbon::parse($this->birthday)->startOfDay();
        $latestAllowedBirthDate = today()->subYears(18)->startOfDay();

        if ($birthDate->greaterThan($latestAllowedBirthDate)) {
            throw ValidationException::withMessages([
                'birthday' => 'El titular debe tener al menos 18 años para registrarse.',
            ]);
        }
    }

    protected function validateSubdependencySelection(): void
    {
        $isAllowedSubdependency = Subdependency::query()
            ->whereKey($this->subdependency_id)
            ->where('dependency_id', $this->dependency_id)
            ->where('status', 'active')
            ->exists();

        if (! $isAllowedSubdependency) {
            throw ValidationException::withMessages([
                'subdependency_id' => 'Selecciona una subdependencia de la dependencia elegida.',
            ]);
        }

        $isActiveDependency = Dependency::query()
            ->whereKey($this->dependency_id)
            ->where('status', 'active')
            ->exists();

        if (! $isActiveDependency) {
            throw ValidationException::withMessages([
                'dependency_id' => 'Selecciona una dependencia activa.',
            ]);
        }
    }

    protected function validateAffiliationStatusSelection(bool $mustBePreaffiliated = true): void
    {
        $statusQuery = AffiliationStatus::query()
            ->whereKey($this->affiliation_status_id)
            ->whereNull('deleted_at');

        if ($mustBePreaffiliated) {
            $statusQuery->where('name', 'Preafiliado');
        }

        if (! $statusQuery->exists()) {
            throw ValidationException::withMessages([
                'affiliation_status_id' => 'Selecciona un estatus de afiliación válido.',
            ]);
        }
    }

    protected function validateUniqueIdentityFields(?int $ignoreInsuredId = null, ?array $originalValues = null): void
    {
        $rfc = mb_strtoupper(trim((string) $this->rfc));

        $originalRfc = mb_strtoupper(trim((string) ($originalValues['rfc'] ?? '')));

        if (! $ignoreInsuredId || $rfc !== $originalRfc) {
            $duplicateRfc = DB::table('insureds')
                ->whereRaw('LOWER(TRIM(COALESCE(rfc, \'\'))) = LOWER(?)', [$rfc])
                ->when($ignoreInsuredId, fn ($query) => $query->where('id', '<>', $ignoreInsuredId))
                ->exists();

            if ($duplicateRfc) {
                throw ValidationException::withMessages([
                    'rfc' => 'Este RFC ya está registrado.',
                ]);
            }
        }

        $email = $this->nullableTrim($this->email);
        $originalEmail = $this->nullableTrim($originalValues['email'] ?? null);

        if ($email === null || ($ignoreInsuredId && mb_strtolower($email) === mb_strtolower((string) $originalEmail))) {
            return;
        }

        $duplicateEmail = DB::table('insureds')
            ->whereRaw('LOWER(TRIM(COALESCE(email, \'\'))) = LOWER(?)', [$email])
            ->when($ignoreInsuredId, fn ($query) => $query->where('id', '<>', $ignoreInsuredId))
            ->exists();

        if ($duplicateEmail) {
            throw ValidationException::withMessages([
                'email' => 'Este correo electrónico ya está registrado.',
            ]);
        }
    }

    public function render()
    {
        $selectDependencies = Dependency::where('status', 'active')->orderBy('name')->get();
        $selectSubdependencies = $this->dependency_id
            ? Subdependency::where('status', 'active')
                ->where('dependency_id', $this->dependency_id)
                ->orderBy('name')
                ->get()
            : collect();
        $selectStates = State::where('status', 'active')->orderBy('name')->get();
        $select5 = Rank::where('status', 'active')->get();
        $selectAffiliationStatuses = AffiliationStatus::query()
            ->whereKey(1)
            ->where('name', 'Preafiliado')
            ->get();

        $workplaceCounties = $this->workplace_state_id
            ? County::where('status', 'active')->where('state_id', $this->workplace_state_id)->orderBy('name')->get()
            : collect();
        $birthplaceCounties = $this->birthplace_state_id
            ? County::where('status', 'active')->where('state_id', $this->birthplace_state_id)->orderBy('name')->get()
            : collect();
        $addressCounties = $this->state_id
            ? County::where('status', 'active')->where('state_id', $this->state_id)->orderBy('name')->get()
            : collect();

        return view('livewire.socioeconomic-benefits.membership-create', [
            'selectDependencies' => $selectDependencies,
            'selectSubdependencies' => $selectSubdependencies,
            'selectStates' => $selectStates,
            'select5' => $select5,
            'selectAffiliationStatuses' => $selectAffiliationStatuses,
            'workplaceCounties' => $workplaceCounties,
            'birthplaceCounties' => $birthplaceCounties,
            'addressCounties' => $addressCounties,
        ]);
    }
}
