<?php

namespace App\Livewire\HumanResources;

use App\Models\Catalogs\Area;
use App\Models\Catalogs\Bank;
use App\Models\Catalogs\Category;
use App\Models\Catalogs\ContractType;
use App\Models\Catalogs\County;
use App\Models\Catalogs\Degree;
use App\Models\Catalogs\Position;
use App\Models\Catalogs\State;
use App\Models\HumanResources\Employee;
use App\Models\HumanResources\EmployeeProcedure;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmployeesCreate extends Component
{
    use WithFileUploads;

    public $areas = [];
    public $positions = [];
    public $banks= [];
    public $states = [];
    public $counties = [];
    public $contract_types = [];
    public $academic_levels=[];
    public $msg = '';
    public $procedureType= null;
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required')]
    public $contract_type = '';
    #[Validate('required|unique:employees,position_id')]
    public $position_id = '';
    #[Validate('required')]
    public $area_id = '';
    #[Validate('required|date')]
    public $effective_date = '';
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
    #[Validate('required|string|min:18|max:18|unique:employees,ine')]
    public $ine;
    #[Validate('required|string|min:18|max:18')]
    public $academic_level;
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
    #[Validate('nullable|max:7')]
    public $interior_number;
    #[Validate('required|numeric|digits:5')]
    public $cp;
    #[Validate('nullable|min:5|max:85')]
    public $locality;
    #[Validate('nullable|numeric|digits:10')]
    public $account_number;
    #[Validate('nullable|numeric|digits:18')]
    public $clabe;
    #[Validate('nullable')]
    public $bank_id;
   // #[Validate('image|max:512')]
    public $photo;
    //#[Validate('image|max:1024')]
    public $signature;

    public function mount(int $procedureType)
    {
        $this->banks = Bank::all();
        $this->states = State::all();
        $this->areas = Area::all();
        $this->academic_levels = Degree::all();
        //permite filtrar solo los puestos disponibles
        $this->positions = Position::whereHas('category', function ($query) {
        $query->whereColumn('covered_position', '<', 'authorized_position');
            })->get();
        $this->contract_types = ContractType::all();
        $this->procedureType = $procedureType;

    }
    public function updatedStateId($value)
    {
        $this->counties = County::where('state_id',(int) $value)->get();
        $this->county_id = ''; // Limpiar municipio seleccionado
    }
    #[On('procedureType')]
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            // Guarda las imágenes en "storage/app/public/public"
            // $photoPath = $this->photo->store('uploads/employees/photo', 'public');
            // $signaturePath = $this->signature->store('uploads/employees/signature', 'public');
            // $photoPath =$this->photo->storeAs('uploads/employees/photos',$this->last_name_1.'_'.$this->name,'public');
            // $signaturePath =$this->signature->storeAs('uploads/employees/signatures',$this->last_name_1.'_'.$this->name,'public');
            $employee = new Employee();
            $employee->procedure_type_id = Str::of($this->procedureType)->trim();
            $employee->contract_type_id = Str::of($this->contract_type)->trim();
            $employee->area_id = Str::of($this->area_id)->trim();
            $employee->position_id = Str::of($this->position_id)->trim();
            $employee->start_date = Str::of($this->effective_date)->trim(); 
            $employee->last_name_1 = Str::of($this->last_name_1)->trim();
            $employee->last_name_2 = Str::of($this->last_name_2)->trim();
            $employee->name = Str::of($this->name)->trim();
            $employee->birthday = Str::of($this->birthday)->trim();
            $employee->sex = Str::of($this->sex)->trim();
            $employee->marital_status = Str::of($this->marital_status)->trim();
            $employee->rfc = Str::of($this->rfc)->trim();
            $employee->curp = Str::of($this->curp)->trim();
            $employee->phone = Str::of($this->phone)->trim();
            $employee->email = Str::of($this->email)->trim();
            $employee->ine = Str::of($this->ine)->trim();
            $employee->academic_level = Str::of($this->academic_level)->trim();
            $employee->emergency_name = Str::of($this->emergency_name)->trim();
            $employee->emergency_number = Str::of($this->emergency_number)->trim();
            $employee->emergency_address = Str::of($this->emergency_address)->trim();
            $employee->state_id = Str::of($this->state_id)->trim();
            $employee->county_id = Str::of($this->county_id)->trim();
            $employee->neighborhood = Str::of($this->neighborhood)->trim();
            $employee->roadway_type = Str::of($this->roadway_type)->trim();
            $employee->street = Str::of($this->street)->trim();
            $employee->outdoor_number = Str::of($this->outdoor_number)->trim();
            $employee->interior_number = Str::of($this->interior_number)->trim();
            $employee->cp = Str::of($this->cp)->trim();
            $employee->locality = Str::of($this->locality)->trim();
            $employee->account_number = Str::of($this->account_number)->trim();
            $employee->clabe = Str::of($this->clabe)->trim();
            $employee->bank_id = Str::of($this->bank_id)->trim();
            // $employee->photo = $photoPath;
            // $employee->signature = $signaturePath;
            $employee->modified_by = Auth::user()->email;
            $employee->save();
            // Trabajando en tabla de movimientos nominales
            $employeProcedures = new EmployeeProcedure();
            $employeProcedures->employee_id = $employee->id;
            $employeProcedures->procedure_type_id = $this->procedureType;
            $employeProcedures->contract_type_id = $this->contract_type;
            $employeProcedures->area_id = $this->area_id;
            $employeProcedures->position_id = $this->position_id;
            $employeProcedures->effective_date = $this->effective_date;
            $employeProcedures->modified_by = Auth::user()->email;
            $employeProcedures->save();
            //Trabajando en la tabla de categorias
            $position = Position::find($employee->position_id);
            $category = Category::find($position->category_id)->increment('covered_position');
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'Empleado : '.$employee->last_name_1.' '.$employee->last_name_2.' '.$employee->name.' fué creado con éxito!','success');   
            // Enviar el mensaje a la vista sin necesidad de recargar
         } catch (Exception $e) {
             DB::rollBack();
             $this->dispatch('showMessage', 'Error : '.$e->getMessage().' Contacte a su Administrador.','error');
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
