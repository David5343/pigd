<?php

namespace App\Livewire\Permissions;

use Livewire\Attributes\Validate;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionsCreate extends Component
{

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
            $permiso->save();

            DB::commit();
            $this->limpiar();
             //session()->flash('msg', 'Permiso creado con éxito!');
             $this->dispatch('show-modal', message: 'Permiso creado con éxito!', type: 'success')->to($this);
         } catch (Exception $e) {
             DB::rollBack();
            //session()->flash('msg_warning', 'Error inesperado. Contacte al administrador.');
            $this->dispatch('show-modal', message: 'Error inesperado. Contacte al administrador.', type: 'warning')->to($this);
        }
        $this->dispatch('show-modal');
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
