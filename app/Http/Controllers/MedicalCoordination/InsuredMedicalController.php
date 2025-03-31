<?php

namespace App\Http\Controllers\MedicalCoordination;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Insured;
use Illuminate\Http\Request;

class InsuredMedicalController extends Controller
{
    public function index()
    {
        return view('medical_coordination.membership.index');

    }
    public function show(string $id)
    {
        $row = Insured::where('id', $id)
            ->with('subdependency.dependency')
            ->with('rank')
            ->with('bank')
            ->with('beneficiaries')
            ->first();
        return view('medical_coordination.membership.show',['titular'=> $row]);

    }
}
