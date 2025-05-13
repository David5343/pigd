<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Models\HumanResources\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('human_resources.employees.index');

    }
    public function create()
    {
        return view('human_resources.employees.create');

    }
    public function show(string $id)
    {
        $employe = Employee::fine($id);
    }
}
