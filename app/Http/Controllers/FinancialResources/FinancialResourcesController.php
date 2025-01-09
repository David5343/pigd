<?php

namespace App\Http\Controllers\FinancialResources;

use App\Http\Controllers\Controller;

class FinancialResourcesController extends Controller
{
    public function index()
    {
        return view('financial_resources.index');

    }
}
