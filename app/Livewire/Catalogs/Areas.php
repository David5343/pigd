<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Area;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Areas extends Component
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

        $areas = Area::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);

        return view('livewire.catalogs.areas', ['lista' => $areas]);
    }
}
