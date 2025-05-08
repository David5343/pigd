<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\ProcedureType;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ProcedureTypeCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|min:2|max:30')]
    public $name;
    #[Validate('nullable|min:2|max:200')]
    public $description;
    public $msg = '';
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $types = new ProcedureType();
            $types->name = Str::of($this->name)->trim();
            $types->description = Str::of($this->description)->trim();
            $types->modified_by = Auth::user()->email;
            $types->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'Tipo de movimiento : '.$types->name.' fué creado con éxito!','success');   
            // Enviar el mensaje a la vista sin necesidad de recargar
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
        return view('livewire.catalogs.procedure-type-create');
    }
}
