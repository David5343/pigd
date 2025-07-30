<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Medication as CatalogsMedication;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Medication extends Component
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
    #[On('updateMedicationList')]
    public function updateMedicationList()
    {
        $this->resetPage();
    }
    public function render()
    {
        $search = trim($this->search);
        $medication = CatalogsMedication::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.catalogs.medication',['lista'=>$medication]);
    }
}
