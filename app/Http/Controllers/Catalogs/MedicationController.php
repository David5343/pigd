<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Medication;
use App\Models\Catalogs\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MedicationController extends Controller
{
    public function index()
    {
        return view('catalogs.medications.index');

    }
    public function create()
    {
        return view('catalogs.medications.create');

    }
    public function edit(string $id)
    {
        $row = Medication::find($id);
        $suppliers = Supplier::all();
        return view('catalogs.medications.edit', ['row' => $row,'suppliers'=>$suppliers]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required','min:5', 'max:70'],
            'pension_type_id'=> ['required']
        ]);

        try {
            DB::beginTransaction();
            $medication = Medication::find($id);

            if (!$medication) {
                return back()->with('msg_warning', 'Medicamento no encontrado.');
            }

            $medication->name = Str::of($request->input('name'))->trim();
            $medication->pension_type_id =$request->input('dependency_id');
            $medication->modified_by = Auth::user()->email;
            $medication->save();
            DB::commit();
            return back()->with('msg', 'Medicamento actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
    public function import()
    {
        return view('catalogs.medications.import');
    }
}
