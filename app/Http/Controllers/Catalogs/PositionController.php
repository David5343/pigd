<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Category;
use App\Models\Catalogs\Position;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PositionController extends Controller
{
    public function index()
    {
        return view('catalogs.positions.index');

    }
    public function create()
    {
        return view('catalogs.positions.create');

    }
    public function edit(string $id)
    {
        $row = Position::find($id);
        $categories = Category::all();
        return view('catalogs.positions.edit', ['row' => $row,'categories'=>$categories]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'position_number' => ['required', 'min:3', 'max:50', 'unique:positions,position_number,'.$id],
            'position_name' => ['required','string'],
            'category_id' => ['required'],

        ]);

        try {
            DB::beginTransaction();
            $position = Position::find($id);
            $position->position_number = Str::of($request->input('position_number'))->trim();
            $position->position_name = Str::of($request->input('position_name'))->trim();
            $position->category_id = Str::of($request->input('category_id'))->trim();
            $position->modified_by = Auth::user()->email;
            $position->save();
            DB::commit();
            return back()->with('msg', 'Puesto actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
