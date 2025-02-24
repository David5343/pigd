<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use Illuminate\Http\Request;

class BeneficiariesController extends Controller
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
}
