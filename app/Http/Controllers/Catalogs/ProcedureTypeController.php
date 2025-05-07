<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\ProcedureType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProcedureTypeController extends Controller
{
    public function index()
    {
        return view('catalogs.procedure-type.index');

    }
    public function create()
    {
        return view('catalogs.procedure-type.create');

    }
    public function edit(string $id)
    {
        $row = ProcedureType::find($id);
        return view('catalogs.procedure-type.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:2', 'max:30', 'unique:procedure_types,name,'.$id],
            'description' => ['nullable','min:2', 'max:200'],

        ]);

        try {
            DB::beginTransaction();
            $types = ProcedureType::find($id);
            $types->name = Str::of($request->input('name'))->trim();
            $types->description = Str::of($request->input('description'))->trim();
            $types->modified_by = Auth::user()->email;
            $types->save();
            DB::commit();
            return back()->with('msg', 'Tipo de movimiento actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
