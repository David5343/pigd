<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\PensionerBeneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PensionerBeneficiaryApiController extends Controller
{
    public function index()
    {
        try {
            $relations = [
                'pensioner',
            ];
            $beneficiaries = PensionerBeneficiary::with($relations)->get();

            if ($beneficiaries->isEmpty()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'beneficiaries' => null,
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'pensioners' => $beneficiaries
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
                'pensioner',
            ];

            $beneficiary = PensionerBeneficiary::with($relations)
                ->where('id', $id)
                ->first();

            if (! $beneficiary) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'beneficiary' => null,
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'beneficiary' => $beneficiary,
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
            'Pensioner_id'=> 'required',
            'File_number' => 'nullable|max:10',
            'Start_date' => 'required|date|max:10',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Birthday' => 'nullable|max:10|date',
            'Sex' => 'required',
            'Rfc' => [
                'required',
                'string',
                'min:13',
                'max:13',//Pendiente de revisar validacion rfc
                Rule::unique('pensioner_beneficiaries')->where(function ($query) use ($request) {
                    return $query->where('pension_types_id', $request->Pension_types_id);
                }),
            ],
            'Curp' => 'nullable | string | min:18 | max: 18',
            'Observations' => 'nullable|min:5|max:250',
            
            'Marital_status' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'pensioners' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }
        DB::beginTransaction();
        try {
            $pensioner = new PensionerBeneficiary();
            $pensioner->subdependency_id = $request->input('Subdependency_id');
            $pensioner->county_id = $request->input('County_id');
            $pensioner->pension_types_id = $request->input('Pension_types_id');
            $pensioner->work_risks_id = $request->input('Work_risks_id') ?: null;
            $pensioner->noi_number = Str::of($request->input('Noi_number'))->trim();
            $pensioner->file_number = Str::of($request->input('File_number'))->trim();
            $pensioner->start_date = $request->input('Start_date');            
            $pensioner->observations = Str::of($request->input('Observations'))->trim() ?: null;
            $pensioner->last_name_1 = Str::of($request->input('Last_name_1'))->trim();
            $pensioner->last_name_2 = Str::of($request->input('Last_name_2'))->trim() ?: null;
            $pensioner->name = Str::of($request->input('Name'))->trim();
            $pensioner->birthday = $request->input('Birthday');
            $pensioner->sex = $request->input('Sex');
            $pensioner->marital_status = $request->input('Marital_status') ?: null;
            $rfc = Str::of($request->input('Rfc'))->trim();
            $curp = Str::of($request->input('Curp'))->trim();
            $pensioner->rfc = Str::upper($rfc);
            $pensioner->curp = Str::upper($curp) ?: null;       
            $pensioner->phone = Str::of($request->input('Phone'))->trim() ?: null;
            $email = Str::of($request->input('Email'))->trim();
            $pensioner->email = Str::lower($email) ?: null;
            $pensioner->address = $request->input('Address');
            $pensioner->status = 'Activo';
            $pensioner->modified_by = Auth::user()->email;
            $pensioner->save();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Registro guardado correctamente',
                'pensioner' => $pensioner,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
