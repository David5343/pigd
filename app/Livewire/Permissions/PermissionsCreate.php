<?php

namespace App\Livewire\Permissions;

use Livewire\Attributes\Validate;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionsCreate extends Component
{

    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|max:30|unique:permissions,name')]
    public $name = '';
    #[Validate('required|min:3')]
    public $category = '';

    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();

            $permiso = new Permission();
            $permiso->name = $this->name;
            $permiso->category = $this->category;
            $permiso->guard_name ='web';
            $permiso->save();

            DB::commit();
            $this->limpiar();
            session()->flash('msg', 'Permiso : '.$permiso->name.' creado con éxito!');
            $this->js("alert('Permiso :".$permiso->name." creado con éxito!')");
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
        return view('livewire.permissions.permissions-create');
    }
}
