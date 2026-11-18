<?php

namespace App\Http\Controllers\MedicalCoordination;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Insured;

class InsuredMedicalController extends Controller
{
    public function index()
    {
        return view('medical_coordination.membership.index');

    }
    public function show(string $id)
    {
        $relations = [
            'subdependency.dependency',
            'rank',
            'workplaceCounty',
            'birthplaceCounty',
            'county.state',
            'affiliationStatus',
            'beneficiaries',
        ];

        $titular = Insured::with($relations)->findOrFail($id);

        return view('medical_coordination.membership.show', compact('titular'));

    }
}
