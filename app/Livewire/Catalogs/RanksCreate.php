<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Rank;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class RanksCreate extends Component
{

    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|min:5|max:70|unique:ranks,name')]
    public $name = '';

        public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $ranks = new Rank();
            $ranks->name = Str::of($this->name)->trim();
            $ranks->modified_by = Auth::user()->email;
            $ranks->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'La Categoría  : '.$ranks->name.' fué creada con éxito!','success');  
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
        return view('livewire.catalogs.ranks-create');
    }
}
