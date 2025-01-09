<?php

namespace App\Http\Controllers\GeneralCoordination;

use App\Http\Controllers\Controller;

class GeneralCoordinationController extends Controller
{
    public function index()
    {
        return view('general_coordination.index');

    }
}
