<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;

class SocioeconomicBenefitsController extends Controller
{
    public function index()
    {
        return view('socioeconomic_benefits.index');

    }
    public function membership()
    {
        return view('socioeconomic_benefits.membership-menu');

    }
}
