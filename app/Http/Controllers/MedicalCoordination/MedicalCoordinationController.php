<?php

namespace App\Http\Controllers\MedicalCoordination;

use App\Http\Controllers\Controller;

class MedicalCoordinationController extends Controller
{
    public function index()
    {
        return view('medical_coordination.index');

    }
}
