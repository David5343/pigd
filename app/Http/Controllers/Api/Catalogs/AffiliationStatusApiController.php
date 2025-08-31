<?php

namespace App\Http\Controllers\Api\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\AffiliationStatus;
use Illuminate\Http\Request;

class AffiliationStatusApiController extends Controller
{
    public function index()
    {
    try {

        $status = AffiliationStatus::all();

        if ($status->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registro no encontrado',
                'statuses' => null,
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Búsqueda realizada correctamente',
            'statuses' => $status,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error en el servidor',
            'error' => $e->getMessage(),
        ], 500);
    }
    }
}
