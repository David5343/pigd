<?php

namespace App\Http\Controllers\Api\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Subdependency;

class SubdependencyApiController extends Controller
{
    public function listar()
    {
        $query = Subdependency::where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();
            
        return response()->json($query);
    }
}
