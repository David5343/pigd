<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StateController extends Controller
{
    public function index()
    {
        return view('catalogs.states.index');

    }
    public function create()
    {
        return view('catalogs.states.create');

    }
    public function edit(string $id)
    {
        $row = State::find($id);
        return view('catalogs.states.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'key' => ['required', 'min:3', 'max:3', 'unique:states,key,'.$id],
            'name' => ['required', 'min:5', 'max:50', 'unique:states,name,'.$id],
        ]);

        try {
            DB::beginTransaction();
            $state = State::find($id);
            $state->key = Str::of($request->input('key'))->trim();
            $state->name = Str::of($request->input('name'))->trim();
            $state->status = 'active';
            $state->modified_by = Auth::user()->email;
            $state->save();
            DB::commit();
            return back()->with('msg', 'Estado actualizada.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
