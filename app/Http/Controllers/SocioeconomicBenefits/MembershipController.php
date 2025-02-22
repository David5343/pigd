<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Insured;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        return view('socioeconomic_benefits.membership.index');

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
}
