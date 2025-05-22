<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Degree;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DegreeController extends Controller
{
    public function index()
    {
        return view('catalogs.degrees.index');

    }
    public function create()
    {
        return view('catalogs.degrees.create');

    }
    public function edit(string $id)
    {
        $row = Degree::find($id);
        return view('catalogs.degrees.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:5', 'max:50', 'unique:degrees,name,'.$id],
            'abbreviation' => ['required','min:2', 'max:5'],

        ]);

        try {
            DB::beginTransaction();
            $degree = Degree::find($id);
            $degree->name = Str::of($request->input('name'))->trim();
            $degree->abbreviation = Str::of($request->input('abbreviation'))->trim();
            $degree->modified_by = Auth::user()->email;
            $degree->save();
            DB::commit();
            return back()->with('msg', 'Grado de estudios actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
