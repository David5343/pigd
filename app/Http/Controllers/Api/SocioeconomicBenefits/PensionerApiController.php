<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Insured;
use App\Models\SocioeconomicBenefits\Pensioner;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PensionerApiController extends Controller
{
    public function index()
    {
        try {
            $relations = [
                'subdependency',
                'county.state',
                'pensionType'
            ];
            $pensioners = Pensioner::with($relations)->get();

            if ($pensioners->isEmpty()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'pensioners' => null,
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'pensioners' => $pensioners
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
                'subdependency',
                'county.state',
            ];

            $pensioner = Pensioner::with($relations)
                ->where('id', $id)
                ->first();

            if (! $pensioner) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'pensioner' => null,
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'pensioner' => $pensioner,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function searchinsuredbyemployee(Request $request, $employee)
    {
        try {
            $relations = [
                'subdependency',
                'rank',
                'workplaceCounty',
                'birthplaceCounty',
                'county',
                'affiliationStatus',
                'beneficiaries'
            ];

            $insured = Insured::with($relations)
                ->where('employee_number', $employee)
                ->where('affiliation_status_id', 4)
                ->first();

            if (!$insured) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'insured' => null,
                ], 404);
            }
            //sleep(33);
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'insured' => $insured,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function searchinsuredbyfilenumber(Request $request, $file)
    {
        try {
            $relations = [
                'subdependency',
                'rank',
                'workplaceCounty',
                'birthplaceCounty',
                'county',
                'affiliationStatus',
                'beneficiaries'
            ];

            $insured = Insured::with($relations)
                ->where('file_number', $file)
                ->where('inactive_motive', 'Pensión')
                ->where('affiliation_status_id', 4)
                ->OrderByDesc('id')
                ->first();

            if (!$insured) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'insured' => null,
                ], 404);
            }
            //sleep(33);
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'insured' => $insured,
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
            'Noi_number' => 'required|max:4|unique:pensioners,noi_number',
            'File_number' => 'nullable|max:10',
            'Start_date' => 'required|date|max:10',
            'Pension_types_id' => 'required',
            'Work_risks_id' => 'nullable',
            'Subdependency_id' => 'required',
            'Observations' => 'nullable|min:5|max:250',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Birthday' => 'nullable|max:10|date',
            'Sex' => 'required',
            'Marital_status' => 'nullable',
            'Rfc' => [
                'required',
                'string',
                'min:13',
                'max:13',
                Rule::unique('pensioners')->where(function ($query) use ($request) {
                    return $query->where('pension_types_id', $request->Pension_types_id);
                }),
            ],
            'Curp' => 'nullable | string | min:18 | max: 18',
            'Phone' => 'nullable|numeric|digits:10',
            'Email' => 'nullable|email|min:5|max:50|unique:pensioners,email',
            'County_id' => 'nullable',
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
            $pensioner = new Pensioner();
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
    public function update(Request $request, $id)
    {

        $rules = [
            'Noi_number' => 'required|max:4|unique:pensioners,noi_number,' . $id,
            'File_number' => 'nullable|max:8',
            'Start_date' => 'required|date|max:10',
            'Pension_types_id' => 'required',
            'Work_risks_id' => 'nullable',
            'Subdependency_id' => 'nullable',
            'Observations' => 'nullable|min:5|max:250',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Birthday' => 'nullable|max:10|date',
            'Sex' => 'required',
            'Marital_status' => 'nullable',
            'Rfc' => [
                'required',
                'string',
                'min:13',
                'max:13',
                Rule::unique('pensioners')->ignore($id) // 👈 Ignora el registro actual
                    ->where(function ($query) use ($request) {
                        return $query->where('pension_types_id', $request->Pension_types_id);
                    }),
            ],
            'Curp' => 'nullable|string|min:18|max:18',
            'Phone' => 'nullable|numeric|digits:10',
            'Email' => 'nullable|email|min:5|max:50|unique:pensioners,email,' . $id,
            'County_id' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'pensioner' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }
        DB::beginTransaction();
        try {
            $pensioner = Pensioner::find($id);
            $pensioner->subdependency_id = $request->input('Subdependency_id') ?: null;
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
    public function photo(Request $request, $id)
    {
        $rules = [
            'Noi_number' => 'required|string|max:8',
            'Photo' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'pensioner' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $pensioner = Pensioner::findOrFail($id);
            if (! $pensioner) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Registro no encontrado',
                    'pensioner' => null,
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }
            $pensioner->photo = Str::of($request->input('Photo'))->trim();
            $pensioner->modified_by = Auth::user()->email;
            $pensioner->save();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Registro actualizado correctamente',
                'pensioner' => $pensioner,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function signature(Request $request, $id)
    {
        $rules = [
            'Noi_number' => 'required|string|max:8',
            'Signature' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'pensioner' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $pensioner = Pensioner::findOrFail($id);
            if (! $pensioner) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Registro no encontrado',
                    'pensioner' => null,
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }
            $pensioner->signature = Str::of($request->input('Signature'))->trim();
            $pensioner->modified_by = Auth::user()->email;
            $pensioner->save();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Registro actualizado correctamente',
                'pensioner' => $pensioner,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function search(Request $request, $data)
    {
        try {
            $relations = [
                'subdependency',
                'county.state',
                'pensionType'
            ];
            $pensioners = Pensioner::with($relations)
                ->where(function ($query) use ($data) {
                    $query->where('noi_number', 'like', "%{$data}%")
                        ->orWhere('rfc', 'like', "%{$data}%")
                        ->orWhere('curp', 'like', "%{$data}%")
                        ->orWhere(DB::raw("CONCAT(last_name_1, ' ', last_name_2, ' ', name)"), 'like', "%{$data}%")
                        ->orWhere(DB::raw("CONCAT(name,' ',last_name_1, ' ', last_name_2)"), 'like', "%{$data}%");
                })->get();

            if ($pensioners->isEmpty()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'pensioners' => null,
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'pensioners' => $pensioners
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function searchByNoi(Request $request, $noi)
    {
        try {
            $relations = [
                'subdependency',
                'county.state',
                'pensionType'
            ];
            $pensioner = Pensioner::with($relations)
                ->where('noi_number', $noi)
                ->first();

            if (!$pensioner) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'pensioner' => null,
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'pensioner' => $pensioner,
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
