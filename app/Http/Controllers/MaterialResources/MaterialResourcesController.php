<?php

namespace App\Http\Controllers\MaterialResources;

use App\Http\Controllers\Controller;

class MaterialResourcesController extends Controller
{
    public function index()
    {
        return view('material_resources.index');

    }
}
