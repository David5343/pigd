<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Bank;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BankController extends Controller
{
    public function index()
    {
        return view('catalogs.banks.index');

    }
    public function create()
    {
        return view('catalogs.banks.create');

    }
    public function edit(string $id)
    {
        $row = Bank::find($id);
        return view('catalogs.banks.edit', ['row' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'key' => ['required', 'min:3', 'max:5', 'unique:banks,key,'.$id],
            'name' => ['required', 'max:50'],
            'legal_name' => ['required', 'min:5', 'max:120'],
        ]);

        try {
            DB::beginTransaction();
            $bank = Bank::find($id);

            if (!$bank) {
                return back()->with('msg_warning', 'Banco no encontrado');
            }

            $bank->key = Str::of($request->input('key'))->trim();
            $bank->name = Str::of($request->input('name'))->trim();
            $bank->legal_name = Str::of($request->input('legal_name'))->trim();
            $bank->status = 'active';
            $bank->modified_by = Auth::user()->email;
            $bank->save();
            DB::commit();
            return back()->with('msg', 'Banco actualizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
