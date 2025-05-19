<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Category;
use App\Models\Catalogs\Position;
use Livewire\Component;
use Livewire\WithPagination;

class Positions extends Component
{
    use WithPagination;
    public $search = '';
    public $numberRows = 10;
    public $authorized = 0;
    public $covered = 0;
    public $free = 0;

    public function mount()
    {
        // Sumar el campo authorized_position
        $this->authorized = Category::sum('authorized_position');
        $this->covered = Category::sum('covered_position');
        $this->free = $this->authorized -$this->covered;
    }

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
        $search = trim($this->search);
        $positions = Position::where(function ($query) use ($search) {
            $query->where('position_number', 'like', '%' . $search . '%')
                  ->orWhere('position_name', 'like', '%' . $search . '%');;
        })
        ->orderBy('position_number', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.catalogs.positions',['lista'=>$positions]);
    }
}
