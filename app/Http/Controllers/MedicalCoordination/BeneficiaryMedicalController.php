<?php

namespace App\Http\Controllers\MedicalCoordination;

use App\Http\Controllers\Controller;
use App\Services\MedicalCoordination\BeneficiaryExpedientData;

class BeneficiaryMedicalController extends Controller
{
    public function index()
    {
        return view('medical_coordination.beneficiaries.index');

    }
    public function show(string $id, BeneficiaryExpedientData $expedientData)
    {
        return view('medical_coordination.beneficiaries.show', [
            'expediente' => $expedientData->forId($id),
        ]);
    }
}
