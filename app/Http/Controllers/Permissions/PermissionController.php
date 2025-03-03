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
            'role' =>['required']
        ]);
        DB::beginTransaction();

        try {

            $permission = Permission::findById($id,'web');
            $permission->name = Str::of($request->input('name'))->trim();
            $permission->guard_name = 'web';
            $permission->save();
            $rol_old = Role::findById($permission->roles->first(), 'web');
            $rol_new = Role::findById($request->input('role'), 'web');
            $rol_old->revokePermissionTo($row->name);
            DB::commit();
            session()->flash('msg', 'Registro de Rol actualizado con éxito!');
            return back();
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('msg_warning', $e->getMessage());
            return back();
        }
    }
}
