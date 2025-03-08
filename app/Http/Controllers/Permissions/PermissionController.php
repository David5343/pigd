<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        return view('permissions.index');

    }
    public function create()
    {
        return view('permissions.create');

    }
    public function edit(string $id)
    {
        $row = Permission::findById($id,'web');
        $roles = Role::all();
        return view('permissions.edit', ['row' => $row,'lista'=>$roles]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:30'],
            'role' => ['required', 'exists:roles,id'] // Validamos que el rol exista
        ]);

        DB::beginTransaction();

        try {
            $permission = Permission::findById($id, 'web');

            if (!$permission) {
                return back()->with('msg_warning', 'Permiso no encontrado');
            }

            // Actualizar nombre del permiso
            $permission->name = Str::of($request->input('name'))->trim();
            $permission->save();

            // Obtener el rol actualmente asignado seleccionado por el usuario (si existe)
            $rol_old = $permission->roles->firstWhere('id', $request->input('old_role'));

            // Obtener el nuevo rol seleccionado por el usuario
            $rol_new = Role::findById($request->input('role'), 'web');

            if (!$rol_new) {
                return back()->with('msg_warning', 'El nuevo rol no existe');
            }

            // Si el permiso está asignado a otro rol, no hacer nada, solo actualizar el nombre
            if ($rol_new->hasPermissionTo($permission->name)) {
                DB::commit();
                return back()->with('msg', 'Permiso actualizado correctamente, sin cambios en los roles');
            }

            // Revocar solo del rol anterior seleccionado si existe
            if ($rol_old && $rol_old->id !== $rol_new->id) {
                $rol_old->revokePermissionTo($permission);
            }

            // Asignar el permiso al nuevo rol
            $rol_new->givePermissionTo($permission);

            DB::commit();
            return back()->with('msg', 'Permiso actualizado y asignado al nuevo rol correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
