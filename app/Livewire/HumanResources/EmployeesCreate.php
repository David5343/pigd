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

class EmployeesCreate extends Component
{
    public $areas = [];
    public $positions = [];
    public $banks= [];
    public $states;
    public $state_id = '';
    public $counties = [];
    public $county_id = '';
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent



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
