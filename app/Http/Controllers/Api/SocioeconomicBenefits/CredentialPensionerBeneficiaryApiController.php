<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\CredentialPensionerBeneficiary;
use Illuminate\Http\Request;

class CredentialPensionerBeneficiaryApiController extends Controller
{
    public function index()
    {
        try {
            $relations = [
                'pensioner.pensionType',
            ];
            $credentials = CredentialPensionerBeneficiary::with($relations)
                ->latest()
                ->limit(25)
                ->get();

            if ($credentials->isEmpty()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'credentials' => null,
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'credentials' => $credentials
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function show($id)
    {
        try {
            $relations = [
                'pensioner.subdependency'
            ];

            $credential = CredentialPensionerBeneficiary::with($relations)
                ->where('id', $id)
                ->first();

            if (!$credential) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'credential' => null,
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'credential' => $credential
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
