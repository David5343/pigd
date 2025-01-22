<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\PensionType;
use Illuminate\Http\Request;

class PensionTypeApiController extends Controller
{
    public function index()
    {
        $tipoPensiones = PensionType::where('status', 'active')
            ->get();

        return response()->json($tipoPensiones);
    }
}
