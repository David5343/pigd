<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\SupplierCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierCategoryController extends Controller
{
    public function index()
    {
        return view('catalogs.supplier-category.index');

    }
    public function create()
    {
        return view('catalogs.supplier-category.create');

    }
    public function edit(string $id)
    {
        $row = SupplierCategory::find($id);
        return view('catalogs.supplier-category.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required','min:5', 'max:70'],
        ]);

        try {
            DB::beginTransaction();
            $supplier_category = SupplierCategory::find($id);

            if (!$supplier_category) {
                return back()->with('msg_warning', 'Categoria de prooveedor no encontrado');
            }

            $supplier_category->name = Str::of($request->input('name'))->trim();
            $supplier_category->modified_by = Auth::user()->email;
            $supplier_category->save();
            DB::commit();
            return back()->with('msg', 'Categoria de prooveedor actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
