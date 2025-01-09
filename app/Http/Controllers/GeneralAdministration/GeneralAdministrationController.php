<?php

namespace App\Http\Controllers\GeneralAdministration;

use App\Http\Controllers\Controller;

class GeneralAdministrationController extends Controller
{
    public function index()
    {
        return view('general_administration.index');

    }
}
