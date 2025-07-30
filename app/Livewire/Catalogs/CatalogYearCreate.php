<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\CatalogYear;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class CatalogYearCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|digits:4|integer|min:1900|max:2100|unique:catalog_years,year')]
    public $name = '';
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $catalogYear = new CatalogYear();
            $catalogYear->year = Str::of($this->name)->trim();
            $catalogYear->modified_by = Auth::user()->email;
            $catalogYear->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'El año de catalogo : '.$catalogYear->year.' fué creado con éxito!','success');
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
        return view('livewire.catalogs.catalog-year-create');
    }
}
