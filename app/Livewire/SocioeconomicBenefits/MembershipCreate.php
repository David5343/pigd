<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\Catalogs\Bank;
use App\Models\Catalogs\County;
use App\Models\Catalogs\State;
use App\Models\Catalogs\Subdependency;
use App\Models\SocioeconomicBenefits\Insured;
use App\Models\SocioeconomicBenefits\Rank;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Database\QueryException;
use Throwable;
use Illuminate\Support\Facades\Log;

class MembershipCreate extends Component
{
    public $folio;
    #[Validate('required|max:8|unique:insureds,file_number')]
    public $file_number;

    #[Validate('required')]
    public $subdependency_id;

    #[Validate('required')]
    public $rank_id;

    #[Validate('required|max:10|date')]
    public $start_date;

    #[Validate('nullable|max:85')]
    public $work_place;

    #[Validate('nullable|min:3|max:120')]
    public $register_motive;

    #[Validate('required')]
    public $affiliate_status;

    #[Validate('nullable|min:5|max:180')]
    public $observations;

    #[Validate('required|min:2|max:20')]
    public $last_name_1;

    #[Validate('required|min:2|max:20')]
    public $last_name_2;

    #[Validate('nullable|min:2|max:30')]
    public $name;

    #[Validate('required')]
    public $blood_type;

    #[Validate('nullable|date')]
    public $birthday;

    #[Validate('nullable | min:3| max:85')]
    public $birthplace;

    #[Validate('required')]
    public $sex;

    #[Validate('nullable')]
    public $marital_status;

    #[Validate('required|min:10|max:13|alpha_num:ascii')]
    public $rfc;

    #[Validate('nullable|max:18|alpha_num:ascii')]
    public $curp;

    #[Validate('nullable|numeric|digits:10')]
    public $phone;

    #[Validate('nullable|email|min:5|max:50|unique:insureds,email')]
    public $email;

    #[Validate('nullable|max:85')]
    public $state;

    #[Validate('nullable|min:3|max:85')]
    public $county;

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
    public function guardar()
    {
        try {
            DB::beginTransaction();
            $this->validate();
            $titular = new Insured();
            $titular->file_number = Str::of($this->file_number)->trim();
            $titular->subdependency_id = $this->subdependency_id;
            $titular->rank_id = $this->rank_id;
            $titular->start_date = $this->start_date;
            $titular->work_place = Str::of($this->work_place)->trim();
            $titular->register_motive = Str::of($this->register_motive)->trim();
            $titular->affiliate_status = $this->affiliate_status;
            $titular->observations = Str::of($this->observations)->trim();
            $titular->last_name_1 = Str::of($this->last_name_1)->trim();
            $titular->last_name_2 = Str::of($this->last_name_2)->trim();
            $titular->name = Str::of($this->name)->trim();
            $titular->blood_type = Str::of($this->blood_type)->trim();
            $titular->birthday = $this->birthday;
            $titular->birthplace = Str::of($this->birthplace)->trim();
            $titular->sex = $this->sex;
            $titular->marital_status = $this->marital_status;
            $rfc = Str::of($this->rfc)->trim();
            $titular->rfc = Str::upper($rfc);
            $curp = Str::of($this->curp)->trim();
            $titular->curp = Str::upper($curp);
            $titular->phone = Str::of($this->phone)->trim();
            $email = Str::of($this->email)->trim();
            $titular->email = Str::lower($email);
            $titular->state = Str::of($this->state)->trim();
            $titular->county = Str::of($this->county)->trim();
            $titular->neighborhood = Str::of($this->neighborhood)->trim();
            $titular->roadway_type = Str::of($this->roadway_type)->trim();
            $titular->street = Str::of($this->street)->trim();
            $titular->outdoor_number = Str::of($this->outdoor_number)->trim();
            $titular->interior_number = Str::of($this->interior_number)->trim();
            $titular->cp = Str::of($this->cp)->trim();
            $titular->locality = Str::of($this->locality)->trim();
            $titular->status = 'active';
            $titular->modified_by = Auth::user()->email;
            $titular->save();
            DB::commit();
            $this->limpiar();
            session()->flash('msg', 'Registro con No. de Expediente: '.$titular->file_number.' creado con éxito!');
            $this->js("alert('Registro con No. de Expediente:".$titular->file_number." creado con éxito!')");
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Error en la consulta SQL: ' . $e->getMessage());
            session()->flash('msg_warning', 'Error en la base de datos. Contacte al administrador.');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error inesperado: ' . $e->getMessage());
            session()->flash('msg_warning', 'Ocurrió un error inesperado. Contacte al administrador.');
        }
    }
    public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
    }
    public function render()
    {
        $select1 = Subdependency::where('status', 'active')->get();
        $select2 = State::where('status', 'active')->get();
        $select3 = County::where('status', 'active')->get();
        $select4 = Bank::where('status', 'active')->get();
        $select5 = Rank::where('status', 'active')->get();
        
        $this->folio = IdGenerator::generate(['table' => 'insureds', 'field' => 'file_number', 'length' => 8, 'prefix' => 'T']);
        $this->file_number = $this->folio;
        return view('livewire.socioeconomic-benefits.membership-create', ['select1' => $select1,
        'select2' => $select2,
        'select3' => $select3,
        'select4' => $select4,
        'select5' => $select5,
        'folio' => $this->folio]);
    }
}
