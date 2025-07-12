<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Supplier;
use App\Models\Catalogs\SupplierCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    public function index()
    {
        return view('catalogs.suppliers.index');

    }
    public function create()
    {
        return view('catalogs.suppliers.create');

    }
    public function edit(string $id)
    {
        $row = Supplier::find($id);
        $supplier_categories = SupplierCategory::all();
        return view('catalogs.supplier.edit', ['row' => $row,'categories'=>$supplier_categories]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required','min:5', 'max:70'],
            'pension_type_id'=> ['required']
        ]);

        try {
            DB::beginTransaction();
            $supplier = Supplier::find($id);

            if (!$supplier) {
                return back()->with('msg_warning', 'Proveedor no encontrado.');
            }

            $supplier->name = Str::of($request->input('name'))->trim();
            $supplier->pension_type_id =$request->input('dependency_id');
            $supplier->modified_by = Auth::user()->email;
            $supplier->save();
            DB::commit();
            return back()->with('msg', 'Proveedor actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
