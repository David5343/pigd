<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\ProcedureType as CatalogsProcedureType;
use Livewire\Component;
use Livewire\WithPagination;

class ProcedureType extends Component
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
        $types = CatalogsProcedureType::where(function($query) {
            $query->Where('name', 'like', '%'.$this->search.'%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.catalogs.procedure-type',['lista'=>$types]);
    }
}
