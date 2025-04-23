<?php

namespace App\Livewire\HumanResources;

use App\Models\Catalogs\Area;
use App\Models\Catalogs\Bank;
use App\Models\Catalogs\County;
use App\Models\Catalogs\Position;
use App\Models\Catalogs\State;
use App\Models\HumanResources\Employee;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmployeesCreate extends Component
{
    use WithFileUploads;

    public $areas = [];
    public $positions = [];
    public $banks= [];
    public $states;
    public $counties = [];
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required')]
    public $mov_type = '';
    #[Validate('required')]
    public $contract_type = '';
    #[Validate('required|unique:employees,position_id')]
    public $position_id = '';
    #[Validate('required')]
    public $area_id = '';
    #[Validate('required|date')]
    public $start_date = '';
    #[Validate('required|min:2|max:20')]
    public $last_name_1;
    #[Validate('nullable|min:2|max:20')]
    public $last_name_2;
    #[Validate('required|min:2|max:30')]
    public $name;
    #[Validate('required|date')]
    public $birthday;
    #[Validate('required')]
    public $sex;
    #[Validate('required')]
    public $marital_status;
    #[Validate('required|min:10|max:13|alpha_num:ascii')]
    public $rfc;
    #[Validate('required|min:10|max:18|alpha_num:ascii')]
    public $curp;
    #[Validate('required|numeric|digits:10')]
    public $phone;
    #[Validate('required|email|min:5|max:50|unique:employees,email')]
    public $email;
    #[Validate('required|min:3|max:30')]
    public $emergency_name;
    #[Validate('required|numeric|digits:10')]
    public $emergency_number;
    #[Validate('required|min:3|max:30')]
    public $emergency_address;
    #[Validate('required')]
    public $state_id = '';
    #[Validate('required')]
    public $county_id = '';
    #[Validate('required|min:5|max:50')]
    public $neighborhood;
    #[Validate('required|min:5|max:50')]
    public $roadway_type;
    #[Validate('required|min:5|max:50')]
    public $street;
    #[Validate('required|max:7')]
    public $outdoor_number;
    #[Validate('required|max:7')]
    public $interior_number;
    #[Validate('required|numeric|digits:5')]
    public $cp;
    #[Validate('required|min:5|max:85')]
    public $locality;
    #[Validate('required|numeric|digits:10')]
    public $account_number;
    #[Validate('required|numeric|digits:18')]
    public $clabe;
    #[Validate('required')]
    public $bank_id;
    #[Validate('required|image|mimes:jpeg,jpg|max:1024')]
    public $photo;
    #[Validate('required|image|mimes:jpeg,jpg|max:1024')]
    public $signature;

    public function mount()
    {
        $this->banks = Bank::all();
        $this->states = State::all();
        $this->areas = Area::all();
        $this->positions = Position::all();

    }
    public function updatedStateId($value)
    {
        $this->counties = County::where('state_id',(int) $value)->get();
        $this->county_id = ''; // Limpiar municipio seleccionado
    }
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $employee = new Employee();
            $employee->modified_by = Auth::user()->email;
            $employee->save();
            DB::commit();
            $this->limpiar();
            session()->flash('msg', 'Empleado : '.$employee->name.' creado con éxito!');
            $this->js("alert('Empleado :".$employee->name." creado con éxito!')");
            $this->dispatch('refreshComponent');
            
            // Enviar el mensaje a la vista sin necesidad de recargar
         } catch (Exception $e) {
             DB::rollBack();
             session()->flash('msg_warning', 'Error : '.$e->getMessage().' Contacte a su Administrador.');
             $this->js("alert('Error :".$e->getMessage()." Contacte a su Administrador.')");
        }

    }
    public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
    }
    public function render()
    {
        return view('livewire.human-resources.employees-create');
    }
}
