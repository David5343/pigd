<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Dependency;
use App\Models\Catalogs\Subdependency;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class SubdependenciesCreate extends Component
{
    public $dependencias = [];
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|min:5|max:70|unique:subdependencies,name')]
    public $name = '';
    #[Validate('required')]
    public $dependency_id = '';
    
    public function mount()
    {
        $this->dependencias = Dependency::where('status','active')->get();
    }
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $subdependency = new Subdependency();
            $subdependency->name = Str::of($this->name)->trim();
            $subdependency->dependency_id =$this->dependency_id;
            $subdependency->status = 'active';
            $subdependency->modified_by = Auth::user()->email;
            $subdependency->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'La Subdependencia  : '.$subdependency->name.' fué creado con éxito!','success');  
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
        return view('livewire.catalogs.subdependencies-create');
    }
}
