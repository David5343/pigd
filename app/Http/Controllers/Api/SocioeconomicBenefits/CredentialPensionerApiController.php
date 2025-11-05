<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\CredentialPensioner;
use App\Models\SocioeconomicBenefits\CredentialRetiree;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CredentialPensionerApiController extends Controller
{
    public function index()
    {
        try {
            $relations = [
                'pensioner',
            ];

            $credentials = CredentialPensioner::with($relations)
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
                'credentials' => $credentials,
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

            $credential = CredentialPensioner::with($relations)
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

    public function store(Request $request)
    {
        $rules = [
            'Pensioner_id' => 'required | numeric',
            'Expires_at' => 'required|date_format:Y-m-d H:i:s',
        ];

        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'credential' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }
        // Verificar si ya existe un registro "VIGENTE" para el pensioner_id dado
        $existeVigente = CredentialPensioner::where('pensioner_id', $request->input('Pensioner_id'))
            ->where('credential_status', 'VIGENTE')
            ->exists();

        if ($existeVigente) {
            $response['errors'] = ['Pensioner_id' => 'Ya existe una credencial vigente para este Pensionado.'];

            return response()->json($response, 200);
        }
        DB::beginTransaction();
        try {
            $fechaActual = now()->toDateTimeString();
            $credential = new CredentialPensioner();
            $credential->pensioner_id = $request->Pensioner_id;
            $credential->issued_at = $fechaActual;
            $credential->expires_at = $request->Expires_at;
            $credential->credential_status = 'VIGENTE';
            $credential->status = 'active';
            $credential->modified_by = Auth::user()->email;
            $credential->save();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Registro guardado correctamente',
                'credential' => $credential,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $dato)
    {
        try {
            $relations = [
                'pensioner.subdependency'
            ];

            $credentials = CredentialPensioner::with($relations)
                ->where('noi_number', $dato)
                ->get();

            if (!$credentials) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'credential' => null,
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
}
