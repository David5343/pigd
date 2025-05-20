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

    public function updatingNumberRows()
    {
        $this->resetPage();
    }

    public function updatedSearch($value)
    {
        $this->search = trim($value);
    }
    public function render()
    {
        $search = trim($this->search);
        $contract = CatalogsContractType::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.catalogs.contract-type',['lista'=>$contract]);
    }
}
