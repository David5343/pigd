<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\MedicationUnit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MedicationUnitController extends Controller
{
        public function index()
    {
        return view('catalogs.medication-unit.index');

    }
    public function create()
    {
        return view('catalogs.medication-unit.create');

    }
    public function edit(string $id)
    {
        $row = MedicationUnit::find($id);
        return view('catalogs.medication-unit.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required','min:5', 'max:70'],
        ]);

        try {
            DB::beginTransaction();
            $medication_unit = MedicationUnit::find($id);

            if (!$medication_unit) {
                return back()->with('msg_warning', 'Unidad de medida no encontrado');
            }

            $medication_unit->name = Str::of($request->input('name'))->trim();
            $medication_unit->modified_by = Auth::user()->email;
            $medication_unit->save();
            DB::commit();
            return back()->with('msg', 'Unidad de medida actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
