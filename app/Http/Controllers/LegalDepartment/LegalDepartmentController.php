<?php

namespace App\Http\Controllers\LegalDepartment;

use App\Http\Controllers\Controller;

class LegalDepartmentController extends Controller
{
    public function index()
    {
        return view('legal_department.index');

    }
}
