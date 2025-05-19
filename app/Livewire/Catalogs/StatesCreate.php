<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\State;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class StatesCreate extends Component
{
        protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|min:3|max:3|unique:states,key')]
    public $key = '';
    #[Validate('required|min:5|max:50|unique:states,name')]
    public $name = '';
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $state = new State();
            $state->key = Str::of($this->key)->trim();
            $state->name = Str::of($this->name)->trim();
            $state->status = 'active';
            $state->modified_by = Auth::user()->email;
            $state->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'Estado  : '.$state->name.' fué creado con éxito!','success');  
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
        return view('livewire.catalogs.states-create');
    }
}
