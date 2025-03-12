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
    public $message;

    public function mount()
    {
        $this->roles = Role::all();
        // $this->permissionsGrouped = Permission::all()->groupBy('category'); 
        $this->permissionsGrouped = Permission::all()->groupBy('category')->map(fn($permissions) => $permissions->toArray())->toArray();
    }
    public function updatedSelectedRole($roleId)
    {
        $role = Role::find($roleId);
    
        if ($role) {
            // Cargar los permisos asignados al rol seleccionado
            $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        } else {
            $this->selectedPermissions = [];
        }
    }

    public function togglePermission($permissionId)
    {
        if (!$this->selectedRole) {
            $this->message = "Selecciona un rol primero.";
            return;
        }
    
        $role = Role::find($this->selectedRole);
    
        if (!$role) {
            $this->message = "El rol seleccionado no existe.";
            return;
        }
    
        // Si ya tiene el permiso, lo quitamos; si no, lo agregamos
        if ($role->hasPermissionTo($permissionId)) {
            $role->revokePermissionTo($permissionId);
        } else {
            $role->givePermissionTo($permissionId);
        }
    
        // Actualizamos la lista de permisos seleccionados
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    
        // Mensaje de confirmación
        $this->message = "Permisos actualizados correctamente.";
    }
    
    public function render()
    {
        return view('livewire.roles.manage-roles');
    }
}
