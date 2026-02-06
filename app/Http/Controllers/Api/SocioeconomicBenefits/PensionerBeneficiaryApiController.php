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
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;

class PensionerBeneficiaryApiController extends Controller
{
    public function index()
    {
        try {
            $relations = [
                'pensioner.pensionType',
            ];
            $beneficiaries = PensionerBeneficiary::with($relations)
                ->latest()
                ->limit(25)
                ->get();

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
                'beneficiaries' => $beneficiaries
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
            'Pensioner_id' => 'required',
            'File_number' => 'nullable|min:8|max:8|unique:pensioner_beneficiaries,file_number',
            'Start_date' => 'required|date|max:10',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Birthday' => 'nullable|max:10|date',
            'Sex' => 'required',
            'Rfc' => 'nullable | string | min:13 | max: 13',
            'Curp' => [
                'required',
                'string',
                'min:18',
                'max:18',
                Rule::unique('pensioner_beneficiaries')
                    ->where(function ($query) use ($request) {
                        return $query->where('affiliate_status', 'Activo');
                    }),
            ],
            'Disabled_person' => 'nullable | string',
            'Relationship' => 'nullable | string',
            'Address' => 'nullable | string|max:200',
            'Observations' => 'nullable|min:5|max:250',
        ];

        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'beneficiary' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }
        DB::beginTransaction();
        try {
            $beneficiary = new PensionerBeneficiary();
            $beneficiary->pensioner_id = $request->input('Pensioner_id');
            $beneficiary->file_number = Str::of($request->input('File_number'))->trim();
            $beneficiary->start_date = $request->input('Start_date');
            $beneficiary->last_name_1 = Str::of($request->input('Last_name_1'))->trim();
            $beneficiary->last_name_2 = Str::of($request->input('Last_name_2'))->trim() ?: null;
            $beneficiary->name = Str::of($request->input('Name'))->trim();
            $beneficiary->birthday = $request->input('Birthday');
            $beneficiary->sex = $request->input('Sex');
            $rfc = Str::of($request->input('Rfc'))->trim();
            $curp = Str::of($request->input('Curp'))->trim();
            $beneficiary->rfc = Str::upper($rfc);
            $beneficiary->curp = Str::upper($curp) ?: null;
            $beneficiary->disabled_person = $request->input('Disabled_person') ?: null;
            $beneficiary->relationship = Str::of($request->input('Relationship'))->trim() ?: null;
            $beneficiary->address = $request->input('Address') ?: null;
            $beneficiary->observations = Str::of($request->input('Observations'))->trim() ?: null;
            $beneficiary->affiliate_status = 'Activo';
            $beneficiary->modified_by = Auth::user()->email;
            $beneficiary->save();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Registro guardado correctamente',
                'beneficiary' => $beneficiary,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'Pensioner_id' => 'required',
            'File_number' => 'nullable|max:10',
            'Start_date' => 'required|date|max:10',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Birthday' => 'nullable|max:10|date',
            'Sex' => 'required',
            'Rfc' => 'nullable | string | min:13 | max: 13',
            'Curp' => [
                'required',
                'string',
                'min:18',
                'max:18',
                Rule::unique('pensioner_beneficiaries')
                    ->where(function ($query) use ($request) {
                        return $query->where('affiliate_status', 'Activo');
                    })->ignore($id),
            ],           
            'Disabled_person' => 'nullable | string',
            'Relationship' => 'nullable | string',
            'Address' => 'nullable | string|max:200',
            'Observations' => 'nullable|min:5|max:250',
        ];

        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'beneficiary' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }
        DB::beginTransaction();
        try {
            $beneficiary = PensionerBeneficiary::find($id);
            $beneficiary->pensioner_id = $request->input('Pensioner_id');
            $beneficiary->file_number = Str::of($request->input('File_number'))->trim();
            $beneficiary->start_date = $request->input('Start_date');
            $beneficiary->last_name_1 = Str::of($request->input('Last_name_1'))->trim();
            $beneficiary->last_name_2 = Str::of($request->input('Last_name_2'))->trim() ?: null;
            $beneficiary->name = Str::of($request->input('Name'))->trim();
            $beneficiary->birthday = $request->input('Birthday');
            $beneficiary->sex = $request->input('Sex');
            $rfc = Str::of($request->input('Rfc'))->trim();
            $curp = Str::of($request->input('Curp'))->trim();
            $beneficiary->rfc = Str::upper($rfc);
            $beneficiary->curp = Str::upper($curp) ?: null;
            $beneficiary->disabled_person = $request->input('Disabled_person') ?: null;
            $beneficiary->relationship = Str::of($request->input('Relationship'))->trim() ?: null;
            $beneficiary->address = $request->input('Address');
            $beneficiary->observations = Str::of($request->input('Observations'))->trim() ?: null;
            $beneficiary->modified_by = Auth::user()->email;
            $beneficiary->save();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Registro guardado correctamente',
                'beneficiary' => $beneficiary,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function idgenerator()
    {
        try {
            $file_number = IdGenerator::generate([
                'table'  => 'pensioner_beneficiaries',
                'field'  => 'file_number',
                'length' => 7,
                'prefix' => 'B'
            ]);

            if (!$file_number) {
                return response()->json([
                    'status'      => 'fail',
                    'message'     => 'Folio no generado',
                    'file_number' => null,
                ], 500);
            }

            return response()->json([
                'status'      => 'success',
                'message'     => 'Folio generado correctamente',
                'file_number' => $file_number,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => 'Error en el servidor',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    public function search(Request $request, $data)
    {
        try {
            $relations = [
                'pensioner.pensionType',
            ];
            $beneficiaries = PensionerBeneficiary::with($relations)
                ->where(function ($query) use ($data) {
                    $query->where('file_number', 'like', "%{$data}%")
                        ->orWhere('curp', 'like', "%{$data}%")
                        ->orWhere(DB::raw("CONCAT(last_name_1, ' ', last_name_2, ' ', name)"), 'like', "%{$data}%")
                        ->orWhere(DB::raw("CONCAT(name,' ',last_name_1, ' ', last_name_2)"), 'like', "%{$data}%");
                })->get();

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
                'beneficiaries' => $beneficiaries
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function searchbyfolio(Request $request, $folio)
    {
        $folio = trim($folio);
        try {
            $relations = [
                'pensioner.pensionType',
            ];
            $pbeneficiary = PensionerBeneficiary::with($relations)
            ->where('file_number', $folio)
            ->first();

            if (!$pbeneficiary) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'beneficiary' => null,
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'beneficiary' => $pbeneficiary,
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
