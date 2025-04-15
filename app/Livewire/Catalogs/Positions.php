<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Position;
use Livewire\Component;
use Livewire\WithPagination;

class Positions extends Component
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
        $positions = Position::where(function($query) {
            $query->Where('position_number', 'like', '%'.$this->search.'%');
        })
        ->orderBy('position_number', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.catalogs.positions',['lista'=>$positions]);
    }
}
