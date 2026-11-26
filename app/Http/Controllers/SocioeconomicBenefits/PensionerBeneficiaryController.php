<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;

class PensionerBeneficiaryController extends Controller
{
    public function index()
    {
        return view('socioeconomic_benefits.pensioner-beneficiaries.index');
    }
}
