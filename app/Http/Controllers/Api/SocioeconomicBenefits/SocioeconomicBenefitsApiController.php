<?php

namespace App\Http\Controllers\API\SocioeconomicBenefits;

use App\Http\Controllers\Controller;

class SocioeconomicBenefitsApiController extends Controller
{
    public function index()
    {
        return view('socioeconomic_benefits.index');

    }
}
