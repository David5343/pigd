<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\SupplierCategory as CatalogsSupplierCategory;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierCategory extends Component
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
        $supplier_category = CatalogsSupplierCategory::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.catalogs.supplier-category',['lista'=>$supplier_category]);
    }
}
