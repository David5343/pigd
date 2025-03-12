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
        return view('permissions.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:30'],
            'category' =>['required','min:3']
        ]);

        try {
            DB::beginTransaction();
            $permission = Permission::findById($id, 'web');

            if (!$permission) {
                return back()->with('msg_warning', 'Permiso no encontrado');
            }

            // Actualizar nombre del permiso
            $permission->name = Str::of($request->input('name'))->trim();
            $permission->category = Str::of($request->input('category'))->trim();
            $permission->save();
            DB::commit();
            return back()->with('msg', 'Permiso actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
