<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersCreate extends Component
{
    public $roles = [];
    public $permissions = [];
    public $selectedRole = null;
    public $selectedPermissions = [];

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function updatedSelectedRole($roleId)
    {
        if ($roleId) {
            $role = Role::findOrFail($roleId);
            $this->permissions = $role->permissions;
            $this->selectedPermissions = $role->permissions->pluck('name')->toArray(); // Cargar permisos seleccionados
        } else {
            $this->permissions = [];
            $this->selectedPermissions = [];
        }
    }
    public function render()
    {

        return view('livewire.users.users-create');
    }
}
