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
        DB::beginTransaction();

        try {

            $row = Role::findById($id,'web');
            $row->name = Str::of($request->input('name'))->trim();
            $row->save();
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
