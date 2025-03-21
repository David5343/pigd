<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Bank;
use App\Models\Catalogs\County;
use App\Models\Catalogs\State;
use App\Models\Catalogs\Subdependency;
use App\Models\SocioeconomicBenefits\Insured;
use App\Models\SocioeconomicBenefits\Rank;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MembershipController extends Controller
{
    public function index()
    {
        return view('socioeconomic_benefits.membership.index');

    }
    public function create()
    {
        return view('socioeconomic_benefits.membership.create');
    }
    public function show(string $id)
    {
        $row = Insured::where('id', $id)
            ->with('subdependency.dependency')
            ->with('rank')
            ->with('bank')
            ->with('beneficiaries')
            ->first();
        return view('socioeconomic_benefits.membership.show',['titular'=> $row]);

    }
    public function edit(string $id)
    {
        $select1 = Subdependency::where('status', 'active')->get();
        $select2 = State::where('status', 'active')->get();
        $select3 = County::where('status', 'active')->get();
        $select4 = Bank::where('status', 'active')->get();
        $select5 = Rank::where('status', 'active')->get();
        $row = Insured::with('Subdependency')
                        ->with('rank')->find($id);

        return view('socioeconomic_benefits.membership.edit', ['select1' => $select1,
            'select2' => $select2,
            'select3' => $select3,
            'select4' => $select4,
            'select5' => $select5,'titular' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'subdependency_id' => ['required'],
            'rank_id' => ['required'],
            'start_date' => ['required', 'max:10', 'date'],
            'work_place' => ['nullable', 'min:3', 'max:85'],
            'register_motive' => ['nullable', 'min:3', 'max:120'],
            'affiliate_status' => ['required'],
            'observations' => ['nullable', 'min:5', 'max:180'],
            'last_name_1' => ['required', 'min:2', 'max:20'],
            'last_name_2' => ['nullable', 'min:2', 'max:20'],
            'name' => ['required', 'min:2', 'max:30'],
            'blood_type' =>['required'],
            'birthday' => ['nullable', 'max:10', 'date'],
            'birthplace' => ['nullable', 'min:3', 'max:85'],
            'sex' => ['nullable'],
            'marital_status' => ['nullable'],
            'rfc' => ['required ', 'min:10', 'max:10 ', ' alpha_num:ascii', 'unique:insureds,rfc,'.$id],
            'curp' => ['nullable', 'min:18', ' max:18 ', 'alpha_num:ascii', 'unique:insureds,curp,'.$id],
            'phone' => ['nullable', 'numeric', 'digits:10'],
            'email' => ['nullable', 'email', 'min:5', 'max:50', 'unique:insureds,email,'.$id],
            'state' => ['nullable', 'min:5', 'max:85'],
            'county' => ['nullable', 'min:3', 'max:85'],
            'neighborhood' => ['nullable', 'min:5', 'max:50'],
            'roadway_type' => ['nullable', 'min:5', 'max:50'],
            'street' => ['nullable', 'min:5', 'max:50'],
            'outdoor_number' => ['nullable', 'max:7'],
            'interior_number' => ['nullable', 'max:7'],
            'cp' => ['nullable', 'numeric', 'digits:5'],
            'locality' => ['nullable', 'min:5', 'max:85'],
        ]);
        DB::beginTransaction();

        try {

            $row = Insured::find($id);
            $row->subdependency_id = $request->input('subdependency_id');
            $row->rank_id = $request->input('rank_id');
            $row->start_date = $request->input('start_date');
            $row->work_place = Str::of($request->input('work_place'))->trim();
            $row->register_motive = Str::of($request->input('register_motive'))->trim();
            $row->affiliate_status = $request->input('affiliate_status');
            $row->observations = Str::of($request->input('observations'))->trim();
            $row->last_name_1 = Str::of($request->input('last_name_1'))->trim();
            $row->last_name_2 = Str::of($request->input('last_name_2'))->trim();
            $row->name = Str::of($request->input('name'))->trim();
            $row->birthday = $request->input('birthday');
            $row->birthplace = Str::of($request->input('birthplace'))->trim();
            $row->sex = $request->input('sex');
            $row->marital_status = $request->input('marital_status');
            $rfc = Str::of($request->input('rfc'))->trim();
            $row->rfc = Str::upper($rfc);
            $curp = Str::of($request->input('curp'))->trim();
            $row->curp = Str::upper($curp);
            $row->phone = Str::of($request->input('phone'))->trim();
            $email = Str::of($request->input('email'))->trim();
            $row->email = Str::lower($email);
            $row->state = Str::of($request->input('state'))->trim();
            $row->county = Str::of($request->input('county'))->trim();
            $row->neighborhood = Str::of($request->input('neighborhood'))->trim();
            $row->roadway_type = Str::of($request->input('roadway_type'))->trim();
            $row->street = Str::of($request->input('street'))->trim();
            $row->outdoor_number = Str::of($request->input('outdoor_number'))->trim();
            $row->interior_number = Str::of($request->input('interior_number'))->trim();
            $row->cp = Str::of($request->input('cp'))->trim();
            $row->locality = Str::of($request->input('locality'))->trim();
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
