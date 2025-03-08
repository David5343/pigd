<?php

namespace App\Livewire\Permissions;

use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsCreate extends Component
{
    public $roles;
    public $role_id='';

    #[Validate('required | string |max:30|unique:permissions,name')]
    public $name = '';

    public function guardar()
    {
        DB::beginTransaction();
        try {
        $this->validate();
        $permiso = new Permission();
        $permiso->name =  $this->name;
        $permiso->guard_name = 'web';
        $permiso->save();
        $rol = Role::findById($this->role_id, 'web');
        $permiso->assignRole($rol);
        DB::commit();
        $this->limpiar();
        session()->flash('msg', 'Permiso creado con éxito!');
        $this->js("alert('Permiso creado con éxito!')");
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('msg_warning', $e->getMessage());
        }
    }
    public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
    }
    public function render()
    {
        $this->roles = Role::all();
        return view('livewire.permissions.permissions-create',['lista'=>$this->roles]);
    }
}
