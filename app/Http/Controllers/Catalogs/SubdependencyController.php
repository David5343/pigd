<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Dependency;
use App\Models\Catalogs\Subdependency;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubdependencyController extends Controller
{
    public function index()
    {
        return view('catalogs.subdependencies.index');

    }
    public function create()
    {
        return view('catalogs.subdependencies.create');

    }
    public function edit(string $id)
    {
        $row = Subdependency::find($id);
        $dependencias = Dependency::where('status','active')->get();
        return view('catalogs.subdependencies.edit', ['row' => $row,'dependencias'=>$dependencias]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:70'],
            'dependency_id'=> ['required']
        ]);

        try {
            DB::beginTransaction();
            $dependency = Subdependency::find($id);

            if (!$dependency) {
                return back()->with('msg_warning', 'subdependencia no encontrado');
            }

            $dependency->name = Str::of($request->input('name'))->trim();
            $dependency->dependency_id =$request->input('dependency_id');
            $dependency->status = 'active';
            $dependency->modified_by = Auth::user()->email;
            $dependency->save();
            DB::commit();
            return back()->with('msg', 'Subdependencia actualizada.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
