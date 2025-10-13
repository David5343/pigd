<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\WorkRisk;
use Illuminate\Http\Request;

class WorkRiskApiController extends Controller
{
    public function index()
    {
        try {

            $work_risks = WorkRisk::all();

            if ($work_risks->isEmpty()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'risks' => null,
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'risks' => $work_risks,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function searchByPension(Request $request, $id)
    {
        try {

            $worksrisks = WorkRisk::with('pensionType')
                ->where('pension_type_id', $id)
                ->get();

            if ($worksrisks->isEmpty()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'risks' => null,
                ], 404);
            }
            //sleep(33);
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'risks' => $worksrisks,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
