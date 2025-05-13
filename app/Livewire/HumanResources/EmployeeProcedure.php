<?php

namespace App\Livewire\HumanResources;

use App\Models\HumanResources\EmployeeProcedure as HumanResourcesEmployeeProcedure;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeProcedure extends Component
{
    use WithPagination;
    public $search = '';
    public $numberRows = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingnumberRows()
    {
        $this->resetPage();
    }
    public function render()
    {
        $movs = HumanResourcesEmployeeProcedure::with([
            'employee', 'procedureType', 'contractType', 'area', 'position'
        ])
        ->where(function ($query) {
            $query->WhereHas('employee', function ($q) {
                      $q->where('last_name_1', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name_2', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%');
                  });
        })
        // ->orderBy('employee.last_name_1', 'asc')
        ->paginate($this->numberRows);
    
        return view('livewire.human-resources.employee-procedure', ['lista' => $movs]);
    }
}
