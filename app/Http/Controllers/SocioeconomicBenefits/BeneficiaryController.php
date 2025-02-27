<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class BeneficiaryController extends Controller
{
    public function index()
    {
        return view('socioeconomic_benefits.beneficiaries.index');

    }
    public function create()
    {
        return view('socioeconomic_benefits.beneficiaries.create');
    }
    public function show(string $id)
    {
        $row = Beneficiary::where('id', $id)
            ->with('insured')
            ->first();
        return view('socioeconomic_benefits.beneficiaries.show',['familiar'=> $row]);

    }
    public function edit(string $id)
    {
        $row = Beneficiary::find($id);

        return view('socioeconomic_benefits.beneficiaries.edit', ['familiar' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'last_name_1' => ['required', 'max:20'],
            'last_name_2' => ['nullable', 'max:20'],
            'name' => ['required', 'max:30'],
            'birthday' => ['required', 'date'],
            'sex' => ['required'],
            'rfc' => ['nullable', 'max:13', 'alpha_num:ascii', 'unique:beneficiaries,rfc,'.$id],
            'curp' => ['nullable', 'max:18', 'alpha_num:ascii', 'unique:beneficiaries,curp,'.$id],
            'disabled_person' => ['required'],
            'relationship' => ['required'],
            'address' => ['required', 'max:150'],
            'observations' => ['nullable', 'max:150'],
        ]);
        DB::beginTransaction();

        try {

            $row = Beneficiary::find($id);
            $row->start_date = $request->input('start_date');
            $row->last_name_1 = Str::of($request->input('last_name_1'))->trim();
            $row->last_name_2 = Str::of($request->input('last_name_2'))->trim();
            $row->name = Str::of($request->input('name'))->trim();
            $row->birthday = $request->input('birthday');
            $row->sex = $request->input('sex');
            $rfc = Str::of($request->input('rfc'))->trim();
            $row->rfc = Str::upper($rfc);
            $curp = Str::of($request->input('curp'))->trim();
            $row->curp = Str::upper($curp);
            $row->disabled_person = $request->input('disabled_person');
            $row->relationship = $request->input('relationship');
            $row->address = Str::of($request->input('address'))->trim();
            $row->observations = Str::of($request->input('observations'))->trim();
            $row->modified_by = Auth::user()->email;
            $row->save();
            DB::commit();
            session()->flash('msg', 'Registro actualizado con éxito!');
            return back();
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('msg_warning', $e->getMessage());
            return back();
        }
    }
}
