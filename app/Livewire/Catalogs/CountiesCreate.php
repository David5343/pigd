<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\County;
use App\Models\Catalogs\State;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class CountiesCreate extends Component
{
    public $states = [];
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|min:5|max:50|unique:counties,name')]
    public $name = '';
    #[Validate('required')]
    public $state_id = '';
    public function mount()
    {
        $this->states = State::all();
    }
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $county = new County();
            $county->name = Str::of($this->name)->trim();
            $county->state_id = Str::of($this->state_id)->trim();
            $county->status = 'active';
            $county->modified_by = Auth::user()->email;
            $county->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'Municipio  : '.$county->name.' fué creado con éxito!','success');  
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
        return view('livewire.catalogs.counties-create');
    }
}
