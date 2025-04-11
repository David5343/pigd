<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('catalogs.categories.index');

    }
    public function create()
    {
        return view('catalogs.categories.create');

    }
    public function edit(string $id)
    {
        $row = Category::find($id);
        return view('catalogs.categories.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:5', 'max:50', 'unique:categories,name,'.$id],
            'salary' => ['required','decimal:2'],
            'compensation' => ['required','decimal:2'],
            'complementary' => ['required','decimal:2'],
            'isr' => ['required','decimal:2'],
            'authorized_position' => ['required','numeric','min_digits:1','max_digits: 3'],

        ]);

        try {
            DB::beginTransaction();
            $category = Category::find($id);
            $salary = number_format((float) $request->input('salary'), 2, '.', '');
            $compensation = number_format((float) $request->input('compensation'), 2, '.', '');
            $complementary = number_format((float) $request->input('complementary'), 2, '.', '');
            $isr = number_format((float) $request->input('isr'), 2, '.', '');
        //Haciendo calculos de sueldo bruto y sueldo neto
        if ($salary !== 0 || $compensation !== 0 || $complementary !== 0) {
            $sueldo_bruto = $salary + $compensation + $complementary;
            $category->gross_salary = $sueldo_bruto;
            if ($isr !== 0) {
                $sueldo_neto = $sueldo_bruto - $isr;
                $category->net_salary = $sueldo_neto;
            }
        }

            $category->name = Str::of($request->input('name'))->trim();       
            $category->salary = Str::of($salary)->trim();
            $category->compensation = Str::of($compensation)->trim();        
            $category->complementary = Str::of($complementary)->trim();   
            $category->isr = Str::of($isr)->trim();
            $category->authorized_position = Str::of($request->input('authorized_position'))->trim();
            $category->covered_position = 0;
            $category->status = 'active';
            $category->modified_by = Auth::user()->email;
            $category->save();
            DB::commit();
            return back()->with('msg', 'Categoria actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
