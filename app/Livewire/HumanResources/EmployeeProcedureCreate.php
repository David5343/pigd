<?php

namespace App\Livewire\HumanResources;

use App\Models\Catalogs\ProcedureType;
use Livewire\Component;

class EmployeeProcedureCreate extends Component
{
    public $procedure_types= [];
    public $msg = '';
    public $procedureType = null;

    public function mount()
    {
        $this->procedure_types = ProcedureType::all();

    }
    public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
    }
    public function render()
    {
        return view('livewire.human-resources.employee-procedure-create');
    }
}
