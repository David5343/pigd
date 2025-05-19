<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\County;
use App\Models\Catalogs\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountyController extends Controller
{
    public function index()
    {
        return view('catalogs.counties.index');

    }
    public function create()
    {
        return view('catalogs.counties.create');

    }
    public function edit(string $id)
    {
        $row = County::find($id);
        $states = State::all();
        return view('catalogs.counties.edit', ['row' => $row,'states' =>$states]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:3', 'max:50', 'unique:counties,name,'.$id],
            'state_id' =>['required']
        ]);

        try {
            DB::beginTransaction();
            $state = County::find($id);
            $state->name = Str::of($request->input('name'))->trim();
            $state->state_id = Str::of($request->input('state_id'))->trim();
            $state->status = 'active';
            $state->modified_by = Auth::user()->email;
            $state->save();
            DB::commit();
            return back()->with('msg', 'Municipio actualizada.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
