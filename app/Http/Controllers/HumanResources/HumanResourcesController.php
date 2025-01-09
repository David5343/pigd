<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;

class HumanResourcesController extends Controller
{
    public function index()
    {
        return view('human_resources.index');

    }
}
