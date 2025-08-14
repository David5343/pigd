<?php

namespace App\Http\Controllers\Api\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\County;

class CountyApiController extends Controller
{
    public function listar()
    {
        $query = County::where('status', 'active')
        ->orderBy('name', 'asc')
        ->get();

        return response()->json($query);
    }
    public function buscarporestados($id)
    {
        $query = County::where('state_id', $id)
        ->orderBy('name', 'asc')
        ->get();

        if ($query->isEmpty()) {
            return response()->json(['message' => 'County not found'], 404);
        }

        return response()->json($query);
    }
}
