<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\CatalogYear as CatalogsCatalogYear;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogYear extends Component
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
        $catalogYear = CatalogsCatalogYear::where(function ($query) use ($search) {
            $query->where('year', 'like', '%' . $search . '%');
        })
        ->orderBy('year', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.catalogs.catalog-year',['lista'=>$catalogYear]);
    }
}
