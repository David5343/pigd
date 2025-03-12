<?php

namespace App\Livewire\Roles;

use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|max:30|unique:roles,name')]
    public $name = '';

    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();

            $role = new Role();
            $role->name = $this->name;
            $role->guard_name ='web';
            $role->save();

            DB::commit();
            $this->limpiar();
            session()->flash('msg', 'Rol : '.$role->name.' creado con éxito!');
            $this->js("alert('Rol : ".$role->name." creado con éxito!')");
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
        return view('livewire.roles.roles-create');
    }
}
