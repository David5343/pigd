<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
        ];
    // Obtener el rol admin
    $role = Role::where('name', 'admin')->first();
            // Si el rol existe, asignar los permisos
            if ($role) {
                $role->syncPermissions($permissions);
            } else {
                $this->command->warn("⚠️ El rol 'admin' no existe. No se asignaron permisos.");
            }
    }
}
