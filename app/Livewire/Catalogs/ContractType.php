<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\ContractType as CatalogsContractType;
use Livewire\Component;
use Livewire\WithPagination;

class ContractType extends Component
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
        $contract = CatalogsContractType::where(function($query) {
            $query->Where('name', 'like', '%'.$this->search.'%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.catalogs.contract-type',['lista'=>$contract]);
    }
}
