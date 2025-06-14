<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Dependency;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class DependenciesCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|min:5|max:50|unique:dependencies,name')]
    public $name = '';
    public $msg = '';
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();

            $dependency = new Dependency();
            $dependency->name = Str::of($this->name)->trim();
            $dependency->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'Dependencia  : '.$dependency->name.' fué creado con éxito!','success'); 
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
        return view('livewire.catalogs.dependencies-create');
    }
}
