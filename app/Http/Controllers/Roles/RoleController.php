<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('roles.index');

    }
    public function create()
    {
        return view('roles.create');

    }
    public function edit(string $id)
    {
        $row = Role::findById($id,'web');
        return view('roles.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:30'],
        ]);

        try {
            DB::beginTransaction();

            $row = Role::findById($id,'web');
            if (!$row) {
                return back()->with('msg_warning', 'Role no encontrado');
            }
            $row->name = Str::of($request->input('name'))->trim();
            $row->save();
            DB::commit();
            return back()->with('msg', 'Permiso actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
    public function manage()
    {
        return view('roles.manage-roles');
    }
}
