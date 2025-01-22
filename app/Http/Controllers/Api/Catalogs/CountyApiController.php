<?php

namespace App\Http\Controllers\Api\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\County;

class CountyApiController extends Controller
{
    public function listar()
    {
        $query = County::where('status', 'active')->get();

        //$subdepe["subdependencias"] = $query;
        return response()->json($query);
    }
}
