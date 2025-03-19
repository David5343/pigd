<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Dependency;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DependenciesCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|max:30|unique:dependencies,name')]
    public $name = '';
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();

            $dependency = new Dependency();
            $dependency->name = $this->name;
            $dependency->save();

            DB::commit();
            $this->limpiar();
            session()->flash('msg', 'Dependencia : '.$dependency->name.' creado con éxito!');
            $this->js("alert('Dependencia :".$dependency->name." creado con éxito!')");
            $this->dispatch('refreshComponent');
            
            // Enviar el mensaje a la vista sin necesidad de recargar
         } catch (Exception $e) {
             DB::rollBack();
             session()->flash('msg_warning', 'Error : '.$e->getMessage().' Contacte a su Administrador.');
             $this->js("alert('Error :".$e->getMessage()." Contacte a su Administrador.')");
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
