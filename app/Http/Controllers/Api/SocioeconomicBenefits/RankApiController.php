<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Rank;
use Illuminate\Http\Request;

class RankApiController extends Controller
{
    public function listar()
    {
        $query = Rank::where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();
        return response()->json($query);
    }
}
