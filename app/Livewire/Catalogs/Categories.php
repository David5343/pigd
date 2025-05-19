<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Category;
use App\Models\Catalogs\Position;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
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
        $categories = Category::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.catalogs.categories',['lista'=>$categories]);
    }
}
