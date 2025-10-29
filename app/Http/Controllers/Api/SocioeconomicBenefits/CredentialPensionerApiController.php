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
        $pensionados = CredentialRetiree::with('retiree')
            ->with('retiree.insured.subdependency')
            ->with('retiree.beneficiary.insured.subdependency')
            ->latest()
            ->limit(25)
            ->get();

        return response()->json($pensionados);
    }

    public function show($id)
    {

        $codigo = 0;
        $response['status'] = 'fail';
        $response['message'] = '';
        $response['errors'] = '';
        $response['insured'] = '';
        $response['beneficiary'] = '';
        $response['retiree'] = '';
        $response['history'] = '';
        $response['credential'] = '0';
        $response['debug'] = '0';
        $credencial = CredentialRetiree::where('id', $id)
            ->with('retiree.insured.subdependency.dependency')
            ->with('retiree.beneficiary.insured.subdependency.dependency')
            ->first();
        if ($credencial == null) {
            $response['message'] = 'Registro no encontrado';
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } else {
            $history = CredentialRetiree::where('retiree_id', $credencial->retiree_id)
                ->where('credential_status', 'VENCIDA')
                ->get();
            $response['status'] = 'success';
            $response['credential'] = $credencial;
            $response['history'] = $history;
            $codigo = 200;

            return response()->json($response, status: $codigo);
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
        DB::beginTransaction();
        try {
            $credential = new CredentialPensioner();
            $credential->pensioner_id = $request->Pensioner_id;
            $credential->issued_at = now();
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

    public function search(Request $request)
    {
        $dato = $request->dato;
        $codigo = 0;
        $response['status'] = 'fail';
        $response['message'] = '';
        $response['errors'] = '';
        $response['insured'] = '';
        $response['beneficiary'] = '';
        $response['retiree'] = '';
        $response['debug'] = '0';

        $credencial = CredentialRetiree::where('credential_status', 'ACTIVO')
            ->with(['retiree.insured', 'retiree.beneficiary'])
            ->orWhereHas('retiree', function ($query) use ($dato) {
                $query->where('file_number', $dato);
            })
            ->orWhereHas('retiree', function ($query) use ($dato) {
                $query->where('noi_number', $dato);
            })
            ->orWhereHas('retiree.insured', function ($query) use ($dato) {
                $query->where('file_number', $dato);
            })
            ->orWhereHas('retiree.insured', function ($query) use ($dato) {
                $query->where('rfc', $dato);
            })
            ->orWhereHas('retiree.insured', function ($query) use ($dato) {
                $query->where('curp', $dato);
            })
            ->orWhereHas('retiree.insured', function ($query) use ($dato) {
                $query->where('name', 'like', '%'.$dato.'%');
            })
            ->orWhereHas('retiree.insured', function ($query) use ($dato) {
                $query->where('last_name_1', 'like', '%'.$dato.'%');
            })
            ->orWhereHas('retiree.insured', function ($query) use ($dato) {
                $query->where('last_name_2', 'like', '%'.$dato.'%');
            })
            ->orWhereHas('retiree.beneficiary', function ($query) use ($dato) {
                $query->where('file_number', $dato);
            })
            ->orWhereHas('retiree.beneficiary', function ($query) use ($dato) {
                $query->where('rfc', $dato);
            })
            ->orWhereHas('retiree.beneficiary', function ($query) use ($dato) {
                $query->where('curp', $dato);
            })
            ->orWhereHas('retiree.beneficiary', function ($query) use ($dato) {
                $query->where('name', 'like', '%'.$dato.'%');
            })
            ->orWhereHas('retiree.beneficiary', function ($query) use ($dato) {
                $query->where('last_name_1', 'like', '%'.$dato.'%');
            })
            ->orWhereHas('retiree.beneficiary', function ($query) use ($dato) {
                $query->where('last_name_2', 'like', '%'.$dato.'%');
            })
            ->get();

        if ($credencial->count() > 0) {
            $response['status'] = 'success';
            $response['retiree'] = $credencial;

            return response()->json($response, 200);
        } else {
            $response['message'] = 'Registro no encontrado';

            return response()->json($response, 200);
        }
    }
}
