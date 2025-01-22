<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use App\Models\SocioeconomicBenefits\Insured;
use App\Models\SocioeconomicBenefits\Retiree;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RetireeApiController extends Controller
{
    public function index()
    {
        $pensionados = Retiree::where('pension_status', 'ACTIVO')
            ->with('pensionType')
            ->with('insured')
            ->with('beneficiary')
            ->latest()
            ->limit(25)
            ->get();

        return response()->json($pensionados);
    }

    public function busqueda(Request $request)
    {
        $dato = $request->dato;
        $codigo = 0;
        $response['status'] = 'fail';
        $response['message'] = '';
        $response['errors'] = '';
        $response['insured'] = '';
        $response['beneficiary'] = '';
        $response['debug'] = '0';
        $titular = Insured::where('affiliate_status', 'Baja')
            ->where('inactive_motive', 'Pensión')
            ->where(function ($query) use ($dato) {
                $query->where('id', $dato)
                    ->orWhere('file_number', $dato)
                    ->orWhere('rfc', $dato)
                    ->orWhere('curp', $dato)
                    ->orWhere('name', 'like', '%'.$dato.'%')
                    ->orWhere('last_name_1', 'like', '%'.$dato.'%')
                    ->orWhere('last_name_2', 'like', '%'.$dato.'%');
            })
            ->get();
        $familiar = Beneficiary::where('affiliate_status', 'Baja')
            //->where('inactive_motive', 'Pensión del Titular')
            ->where(function ($query) use ($dato) {
                $query->where('id', $dato)
                    ->orwhere('file_number', $dato)
                    ->orwhere('rfc', $dato)
                    ->orwhere('curp', $dato)
                    ->orwhere('name', 'like', '%'.$dato.'%')
                    ->orwhere('last_name_1', 'like', '%'.$dato.'%')
                    ->orwhere('last_name_2', 'like', '%'.$dato.'%');
            })
            ->get();
        if ($titular->count() > 0) {
            $response['status'] = 'success';
            $response['insured'] = $titular;
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } elseif ($familiar->count() > 0) {
            $response['status'] = 'success';
            $response['beneficiary'] = $familiar;
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } else {

            $response['status'] = 'fail';
            $response['message'] = 'Registro no encontrado';
            $codigo = 200;

            return response()->json($response, status: $codigo);
        }
    }

    public function store(Request $request)
    {
        $response['status'] = 'fail';
        $response['errors'] = '';
        $response['retiree'] = '';
        $response['debug'] = '';

        $rules = [
            'Noi_number' => 'nullable| max:5',
            'Pension_type_id' => 'required | numeric',
            'Start_date' => 'required|date_format:Y-m-d',
        ];
        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            $response['errors'] = $validator->errors()->toArray();
            $response['debug'] = $request->input('Start_date');

            return response()->json($response, 200);
        }
        DB::beginTransaction();
        try {

            $pension = new Retiree();
            $no_afiliacion = IdGenerator::generate(['table' => 'retirees', 'field' => 'file_number', 'length' => 8, 'prefix' => 'P']);
            $pension->file_number = $no_afiliacion;
            $pension->noi_number = $request->input('Noi_number');
            $pension->start_date = $request->input('Start_date');
            $pension->insured_type = $request->input('Insured_type');
            $pension->pension_type_id = $request->input('Pension_type_id');
            if ($request->input('Insured_type') == 'Titular') {
                $pension->insured_id = $request->input('Insured_id');
                $pension->beneficiary_id = null;
            } else {
                $pension->beneficiary_id = $request->input('Beneficiary_id');
                $pension->insured_id = null;
            }
            $pension->pension_status = 'ACTIVO';
            $pension->status = 'active';
            $pension->modified_by = Auth::user()->email;
            $pension->save();
            DB::commit();
            $response['status'] = 'success';
            $response['retiree'] = $pension->file_number;

            return response()->json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            $response['debug'] = $e->getMessage();

            return response()->json($response, 200);
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

        $retiree = Retiree::where('pension_status', 'ACTIVO')
            ->with(['pensionType', 'insured', 'beneficiary'])
            ->where('file_number', $dato)
            ->orwhere('noi_number', $dato)
            ->orWhereHas('insured', function ($query) use ($dato) {
                $query->where('file_number', $dato);
            })
            ->orWhereHas('insured', function ($query) use ($dato) {
                $query->where('rfc', $dato);
            })
            ->orWhereHas('insured', function ($query) use ($dato) {
                $query->where('curp', $dato);
            })
            ->orWhereHas('insured', function ($query) use ($dato) {
                $query->where('name', 'like', '%'.$dato.'%');
            })
            ->orWhereHas('insured', function ($query) use ($dato) {
                $query->where('last_name_1', 'like', '%'.$dato.'%');
            })
            ->orWhereHas('insured', function ($query) use ($dato) {
                $query->where('last_name_2', 'like', '%'.$dato.'%');
            })
            ->orWhereHas('beneficiary', function ($query) use ($dato) {
                $query->where('file_number', $dato);
            })
            ->orWhereHas('beneficiary', function ($query) use ($dato) {
                $query->where('rfc', $dato);
            })
            ->orWhereHas('beneficiary', function ($query) use ($dato) {
                $query->where('curp', $dato);
            })
            ->orWhereHas('beneficiary', function ($query) use ($dato) {
                $query->where('name', 'like', '%'.$dato.'%');
            })
            ->orWhereHas('beneficiary', function ($query) use ($dato) {
                $query->where('last_name_1', 'like', '%'.$dato.'%');
            })
            ->orWhereHas('beneficiary', function ($query) use ($dato) {
                $query->where('last_name_2', 'like', '%'.$dato.'%');
            })
            ->get();

        if ($retiree->count() > 0) {
            $response['status'] = 'success';
            $response['retiree'] = $retiree;

            return response()->json($response, 200);
        } else {
            $response['message'] = 'Registro no encontrado';

            return response()->json($response, 200);
        }
    }
}
