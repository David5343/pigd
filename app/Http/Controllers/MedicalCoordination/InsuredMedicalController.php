<?php

namespace App\Http\Controllers\MedicalCoordination;

use App\Http\Controllers\Controller;
use App\Services\MedicalCoordination\InsuredExpedientData;

class InsuredMedicalController extends Controller
{
    public function index()
    {
        return view('medical_coordination.membership.index');

    }
    public function show(string $id, InsuredExpedientData $expedientData)
    {
        return view('medical_coordination.membership.show', [
            'expediente' => $expedientData->forId($id),
        ]);
    }
}
