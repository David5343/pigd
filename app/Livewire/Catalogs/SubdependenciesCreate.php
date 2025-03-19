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
    #[Validate('required|string|max:70')]
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
            session()->flash('msg', 'La Subdependencia : '.$subdependency->name.' creado con éxito!');
            $this->js("alert('La Subdependencia :".$subdependency->name." creado con éxito!')");
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
        return view('livewire.catalogs.subdependencies-create');
    }
}
