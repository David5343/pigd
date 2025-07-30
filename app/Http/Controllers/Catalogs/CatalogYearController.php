<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\CatalogYear;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CatalogYearController extends Controller
{
    public function index()
    {
        return view('catalogs.catalog-year.index');

    }
    public function create()
    {
        return view('catalogs.catalog-year.create');

    }
    public function edit(string $id)
    {
        $row = CatalogYear::find($id);
        return view('catalogs.catalog-year.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required','integer','digits:4','min:1900', 'max:2100', 'unique:catalog_years,year,' . $id],
        ]);

        try {
            DB::beginTransaction();
            $catalogYear = CatalogYear::find($id);

            if (!$catalogYear) {
                return back()->with('msg_warning', 'Año de catalogo no encontrado');
            }

            $catalogYear->year = Str::of($request->input('name'))->trim();
            $catalogYear->modified_by = Auth::user()->email;
            $catalogYear->save();
            DB::commit();
            return back()->with('msg', 'Año de catalogo actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
