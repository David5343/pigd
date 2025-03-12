<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRoles extends Component
{
    public $roles;
    public $permissionsGrouped = [];
    public $selectedRole;
    public array $selectedPermissions = [];

    public function mount()
    {
        $this->roles = Role::all();
        $this->permissionsGrouped = Permission::all()->groupBy('category')->map(fn($permissions) => $permissions->toArray())->toArray();
    
        // Seleccionar automáticamente el primer rol si existe
        if ($this->roles->isNotEmpty()) {
            $this->selectedRole = $this->roles->first()->id;
            $this->loadPermissions();
        }
    }

    public function updatedSelectedRole()
    {
        $this->loadPermissions();
    }
    private function loadPermissions()
    {
        $role = Role::find($this->selectedRole);
        $this->selectedPermissions = $role ? $role->permissions->pluck('id')->toArray() : [];
    }
    public function togglePermission($permissionId)
    {
        if (!$this->selectedRole) {
            $this->dispatch('notify', 'Selecciona un rol primero.');
            return;
        }

        $role = Role::find($this->selectedRole);
        $permission = Permission::find($permissionId);

        if (!$role || !$permission) {
            $this->dispatch('notify', 'Error: Rol o permiso no encontrado.');
            return;
        }

        // Alternar permiso
        if ($role->hasPermissionTo($permission->name)) {
            $role->revokePermissionTo($permission->name);
        } else {
            $role->givePermissionTo($permission->name);
        }

        // Recargar permisos para reflejar cambios
        $this->loadPermissions();

        // Emitir notificación
        $this->dispatch('notify', 'Permisos actualizados correctamente.');
    }

    public function render()
    {
        return view('livewire.roles.manage-roles');
    }
}

