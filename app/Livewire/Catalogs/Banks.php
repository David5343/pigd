<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Bank;
use Livewire\Component;
use Livewire\WithPagination;

class Banks extends Component
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
        $banks = Bank::where(function($query) {
            $query->Where('name', 'like', '%'.$this->search.'%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.catalogs.banks',['lista'=>$banks]);
    }
}
