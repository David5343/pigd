<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Area;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AreasCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|max:30|unique:areas,name')]
    public $name = '';

    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();

            $area = new Area();
            $area->name = $this->name;
            $area->save();

            DB::commit();
            $this->limpiar();
            session()->flash('msg', 'Área : '.$area->name.' creado con éxito!');
            $this->js("alert('Área :".$area->name." creado con éxito!')");
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
        return view('livewire.catalogs.areas-create');
    }
}
