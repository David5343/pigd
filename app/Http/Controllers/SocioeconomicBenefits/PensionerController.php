<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;

class PensionerController extends Controller
{
    public function index()
    {
        return view('socioeconomic_benefits.pensioners.index');
    }
}
