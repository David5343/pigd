<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Area;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AreaController extends Controller
{
    public function index()
    {
        return view('catalogs.areas.index');

    }
    public function create()
    {
        return view('catalogs.areas.create');

    }
    public function edit(string $id)
    {
        $row = Area::find($id);
        return view('catalogs.areas.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:5', 'max:50', 'areas,name,'.$id],
        ]);

        try {
            DB::beginTransaction();
            $area = Area::find($id);
            $area->name = Str::of($request->input('name'))->trim();
            $area->modified_by = Auth::user()->email;
            $area->save();
            DB::commit();
            return back()->with('msg', 'Área actualizada.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
