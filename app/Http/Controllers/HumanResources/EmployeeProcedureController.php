<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeProcedureController extends Controller
{
    public function index()
    {
        return view('human_resources.employee-procedure.index');

    }
    public function create()
    {
        return view('human_resources.employee-procedure.create');

    }
}
