<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\ContractType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContractTypeController extends Controller
{
    public function index()
    {
        return view('catalogs.contract-type.index');

    }
    public function create()
    {
        return view('catalogs.contract-type.create');

    }
    public function edit(string $id)
    {
        $row = ContractType::find($id);
        return view('catalogs.contract-type.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:2', 'max:30', 'unique:procedure_types,name,'.$id],
            'description' => ['nullable','min:2', 'max:200'],

        ]);

        try {
            DB::beginTransaction();
            $contract = ContractType::find($id);
            $contract->name = Str::of($request->input('name'))->trim();
            $contract->description = Str::of($request->input('description'))->trim();
            $contract->modified_by = Auth::user()->email;
            $contract->save();
            DB::commit();
            return back()->with('msg', 'Tipo de contrato actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
