<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\Catalogs\AffiliationStatus;
use App\Models\SocioeconomicBenefits\Insured;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Throwable;

class MembershipEdit extends MembershipCreate
{
    public bool $isOpen = false;

    public ?array $titularData = null;

    public ?int $insuredId = null;

    #[On('open-membership-edit')]
    public function open(int $insuredId): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'JefaturaCoordinacion',
            'PrestacionesSocioEconomicas',
            'JefaturaPrestaciones',
            'SuperAdmin',
        ]), 403);

        $titular = Insured::with([
            'subdependency.dependency',
            'workplaceCounty',
            'birthplaceCounty',
            'county.state',
            'affiliationStatus',
        ])->findOrFail($insuredId);

        $this->resetValidation();
        $this->titularData = [
            'id' => $titular->id,
            'file_number' => $titular->file_number,
            'affiliation_status_name' => $titular->affiliationStatus?->name,
        ];
        $this->insuredId = $titular->id;

        $this->dependency_id = $titular->subdependency?->dependency_id;
        $this->subdependency_id = $titular->subdependency_id;
        $this->rank_id = $titular->rank_id;
        $this->employee_number = $titular->employee_number;
        $this->start_date = $this->dateForInput($titular->start_date);
        $this->workplace_state_id = $titular->workplaceCounty?->state_id;
        $this->workplace_county_id = $titular->workplace_county_id;
        $this->register_motive = $titular->register_motive;
        $this->affiliation_status_id = $titular->affiliation_status_id;
        $this->observations = $titular->observations;
        $this->last_name_1 = $titular->last_name_1;
        $this->sin_apellido_paterno = blank($titular->last_name_1);
        $this->last_name_2 = $titular->last_name_2;
        $this->sin_apellido_materno = blank($titular->last_name_2);
        $this->name = $titular->name;
        $this->blood_type = $titular->blood_type;
        $this->birthday = $this->dateForInput($titular->birthday);
        $this->birthplace_state_id = $titular->birthplaceCounty?->state_id;
        $this->birthplace_county_id = $titular->birthplace_county_id;
        $this->sex = $titular->sex;
        $this->marital_status = $titular->marital_status;
        $this->rfc = $titular->rfc;
        $this->curp = $titular->curp;
        $this->phone = $titular->phone;
        $this->email = $titular->email;
        $this->state_id = $titular->county?->state_id;
        $this->county_id = $titular->county_id;
        $this->neighborhood = $titular->neighborhood;
        $this->roadway_type = $titular->roadway_type;
        $this->street = $titular->street;
        $this->outdoor_number = $titular->outdoor_number;
        $this->interior_number = $titular->interior_number;
        $this->cp = $titular->cp;
        $this->locality = $titular->locality;
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->titularData = null;
        $this->insuredId = null;
        $this->resetValidation();
    }

    public function cerrarModal(): void
    {
        $this->close();
    }

    public function actualizar(): void
    {
        try {
            DB::beginTransaction();

            $titular = Insured::findOrFail($this->insuredId);
            $this->validate();
            $this->validateSurnames();
            $this->validateNoDuplicateFullName($titular->id, [
                'name' => $titular->name,
                'last_name_1' => $titular->last_name_1,
                'last_name_2' => $titular->last_name_2,
            ]);
            $this->validateUniqueIdentityFields($titular->id, [
                'rfc' => $titular->rfc,
                'email' => $titular->email,
            ]);

            if ($this->birthday !== $this->dateForInput($titular->birthday)) {
                $this->validateAdultBirthDate();
            }

            $this->validateSubdependencySelection();
            $this->validateAffiliationStatusSelection(mustBePreaffiliated: false);
            $this->validateCountySelections();

            $titular->subdependency_id = $this->subdependency_id;
            $titular->rank_id = $this->rank_id;
            $titular->employee_number = $this->nullableTrim($this->employee_number);
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
            $titular->rfc = Str::upper(Str::of($this->rfc)->trim());
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
            $titular->modified_by = Auth::user()->email;
            $titular->save();

            DB::commit();

            $this->dispatch(
                'insured-updated',
                message: 'El titular con folio '.$titular->file_number.' se actualizó correctamente.'
            );
            $this->close();
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Error al actualizar titular: '.$e->getMessage());
            session()->flash('msg_warning', 'No se pudieron guardar los cambios. Contacte al administrador.');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error inesperado al actualizar titular: '.$e->getMessage());
            session()->flash('msg_warning', 'Ocurrió un error inesperado. Intente nuevamente.');
        }
    }

    public function render()
    {
        $view = parent::render();
        $data = $view->getData();
        $data['selectAffiliationStatuses'] = $this->titularData
            ? AffiliationStatus::query()
                ->whereNull('deleted_at')
                ->orderBy('id')
                ->get()
            : collect();
        $data['titularData'] = $this->titularData;

        return view('livewire.socioeconomic-benefits.membership-edit', $data);
    }

    private function dateForInput(?string $date): ?string
    {
        return filled($date) ? Carbon::parse($date)->toDateString() : null;
    }
}
