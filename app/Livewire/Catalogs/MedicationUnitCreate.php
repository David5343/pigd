<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\MedicationUnit;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class MedicationUnitCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|min:3|max:20|unique:medication_units,name')]
    public $name = '';
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $medication_unit = new MedicationUnit();
            $medication_unit->name = Str::of($this->name)->trim();
            $medication_unit->modified_by = Auth::user()->email;
            $medication_unit->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'La Unidad de Medida : '.$medication_unit->name.' fué creado con éxito!','success');
         } catch (Exception $e) {
             DB::rollBack();
             $this->dispatch('showMessage', 'Error : '.$e->getMessage().' Contacte a su Administrador.','error');
        }

    }
    public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
    }
    public function render()
    {
        return view('livewire.catalogs.medication-unit-create');
    }
}
