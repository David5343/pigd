<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Degree;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class DegreesCreate extends Component
{
        protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|unique:degrees,name|min:5|max:50')]
    public $name;
    #[Validate('required|min:2|max:5')]
    public $abbreviation;
    public $msg = '';
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $degree = new Degree();
            $degree->name = Str::of($this->name)->trim();
            $degree->abbreviation = Str::of($this->abbreviation)->trim();
            $degree->modified_by = Auth::user()->email;
            $degree->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'Grado de estudio : '.$degree->name.' fué creado con éxito!','success');   
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
        return view('livewire.catalogs.degrees-create');
    }
}
