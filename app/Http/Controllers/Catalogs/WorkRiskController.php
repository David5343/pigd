<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\PensionType;
use App\Models\Catalogs\WorkRisk;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WorkRiskController extends Controller
{
    public function index()
    {
        return view('catalogs.work-risk.index');

    }
    public function create()
    {
        return view('catalogs.work-risk.create');

    }
    public function edit(string $id)
    {
        $row = WorkRisk::find($id);
        $pension_types = PensionType::all();
        return view('catalogs.work-risk.edit', ['row' => $row,'pensiones'=>$pension_types]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required','min:5', 'max:70'],
            'pension_type_id'=> ['required']
        ]);

        try {
            DB::beginTransaction();
            $work_risks = WorkRisk::find($id);

            if (!$work_risks) {
                return back()->with('msg_warning', 'Tipo de riesgo no encontrado');
            }

            $work_risks->name = Str::of($request->input('name'))->trim();
            $work_risks->pension_type_id =$request->input('dependency_id');
            $work_risks->modified_by = Auth::user()->email;
            $work_risks->save();
            DB::commit();
            return back()->with('msg', 'Tipo de riesgo actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
