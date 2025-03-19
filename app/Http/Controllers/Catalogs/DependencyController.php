<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Dependency;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DependencyController extends Controller
{
    public function index()
    {
        return view('dependencies.index');

    }
    public function create()
    {
        return view('dependencies.create');

    }
    public function edit(string $id)
    {
        $row = Dependency::find($id);
        return view('dependencies.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:50'],
        ]);

        try {
            DB::beginTransaction();
            $dependency = Dependency::find($id);

            if (!$dependency) {
                return back()->with('msg_warning', 'Dependencia no encontrado');
            }

            // Actualizar nombre del permiso
            $dependency->name = Str::of($request->input('name'))->trim();
            $dependency->save();
            DB::commit();
            return back()->with('msg', 'Dependencia actualizada.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
