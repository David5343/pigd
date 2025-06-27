<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Rank;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RankController extends Controller
{
    public function index()
    {
        return view('catalogs.ranks.index');

    }
    public function create()
    {
        return view('catalogs.ranks.create');

    }
    public function edit(string $id)
    {
        $row = Rank::find($id);
        return view('catalogs.ranks.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required','min:5', 'max:70'],
        ]);

        try {
            DB::beginTransaction();
            $ranks = Rank::find($id);

            if (!$ranks) {
                return back()->with('msg_warning', 'Categoría no encontrado');
            }

            $ranks->name = Str::of($request->input('name'))->trim();
            $ranks->modified_by = Auth::user()->email;
            $ranks->save();
            DB::commit();
            return back()->with('msg', 'Categoría actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
