<?php

namespace App\Livewire\Catalogs;

use App\Imports\MedicationsImport;
use App\Models\Catalogs\CatalogYear;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class MedicationImport extends Component
{
    use WithFileUploads;

    public $file;
    public $catalog_years = [];
    public $selectedYearId = null;

    public function mount()
    {
        $this->catalog_years = CatalogYear::all();
    }
    public function import()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        Excel::import(new MedicationsImport, $this->file);

        session()->flash('success', 'Medicamentos importados correctamente.');
        $this->reset('file');
    }
    public function render()
    {
        return view('livewire.catalogs.medication-import');
    }
}
