<?php

namespace App\Livewire\HumanResources;

use App\Models\HumanResources\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class Employees extends Component
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
        $employees = Employee::where(function($query) {
            $query->Where('last_name_1', 'like', '%'.$this->search.'%')
            ->orWhere('last_name_2', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.human-resources.employees',['lista'=>$employees]);
    }
}
