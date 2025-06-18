<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\PensionType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PensionTypeController extends Controller
{
    public function index()
    {
        return view('catalogs.pension-type.index');

    }
    public function create()
    {
        return view('catalogs.pension-type.create');

    }
    public function edit(string $id)
    {
        $row = PensionType::find($id);
        return view('catalogs.pension-type.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:5', 'max:50', 'unique:pension_types,name,'.$id],
        ]);

        try {
            DB::beginTransaction();
            $pension_type = PensionType::find($id);
            $pension_type->name = Str::of($request->input('name'))->trim();
            $pension_type->modified_by = Auth::user()->email;
            $pension_type->save();
            DB::commit();
            return back()->with('msg', 'Tipo de Pensión actualizada.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
