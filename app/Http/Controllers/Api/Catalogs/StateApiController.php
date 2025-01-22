<?php

namespace App\Http\Controllers\Api\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\State;

class StateApiController extends Controller
{
    public function listar()
    {
        $query = State::where('status', 'active')->get();

        //$response["estados"] = $query;
        return response()->json($query);
        //return response()->json($response);
    }
}
