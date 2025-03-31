<?php

namespace App\Http\Controllers\MedicalCoordination;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use Illuminate\Http\Request;

class BeneficiaryMedicalController extends Controller
{
    public function index()
    {
        return view('medical_coordination.beneficiaries.index');

    }
    public function show(string $id)
    {
        $row = Beneficiary::where('id', $id)
            ->with('insured')
            ->first();
        return view('medical_coordination.beneficiaries.show',['familiar'=> $row]);
    }
}
