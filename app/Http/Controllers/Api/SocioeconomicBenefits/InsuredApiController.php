<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use App\Models\SocioeconomicBenefits\Insured;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InsuredApiController extends Controller
{
    public function index()
    {
        try {
            $relations = [
                'subdependency',
                'rank',
                'workplaceCounty',
                'birthplaceCounty',
                'county.state',
                'affiliationStatus',
                'beneficiaries'
            ];

            $insureds = Insured::with($relations)
                ->latest()
                ->limit(25)
                ->get();

            if ($insureds->isEmpty()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'insureds' => null,
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'insureds' => $insureds,
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
                'rank',
                'workplaceCounty',
                'birthplaceCounty',
                'county.state',
                'affiliationStatus',
                'beneficiaries'
            ];

            $insured = Insured::with($relations)
                ->where('id', $id)
                ->first();

            $history = Insured::with($relations)
                ->where('file_number', $insured->file_number)
                ->where('affiliation_status_id', 4)
                ->get();

            if (!$insured && !$history) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'insured' => null,
                    'history' => null,
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'insured' => $insured,
                'history' => $history,
            ], 200);
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
                'table'  => 'insureds',
                'field'  => 'file_number',
                'length' => 8,
                'prefix' => 'T'
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

    public function store(Request $request)
    {

        $rules = [
            'Subdependency_id' => 'required',
            'Rank_id' => 'required',
            'Workplace_county_id' => 'nullable',
            'Birthplace_county_id' => 'nullable',
            'Affiliation_status_id' => 'required',
            'County_id' => 'nullable',
            //Valida si ya hay un registro en la tabla insureds con el mismo numero de afiliacion con un estatus de activo
            'File_number' => [
                'required',
                'max:8',
                Rule::unique('insureds')->where(fn(Builder $query) => $query->where('affiliation_status_id', 2)),
            ],
            'Employee_number' => 'required|min:6|max:6|unique:insureds,employee_number',
            'Start_date' => 'required|date|max:10',
            'Register_motive' => 'nullable|min:3|max:250',
            'Observations' => 'nullable|min:5|max:250',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Birthday' => 'nullable|max:10|date',
            'Sex' => 'required',
            'Marital_status' => 'nullable',
            'Rfc' => [
                'required',
                'alpha_num:ascii',
                Rule::unique('insureds')->where(fn(Builder $query) => $query->where('affiliation_status_id', 2)),
            ],
            'Curp' => 'nullable | string | min:18 | max: 18',
            'Phone' => 'nullable|numeric|digits:10',
            'Email' => 'nullable|email|min:5|max:50|unique:insureds,email',
            'Neighborhood' => 'nullable|min:5|max:50',
            'Roadway_type' => 'nullable|min:5|max:50',
            'Street' => 'nullable|min:5|max:50',
            'Outdoor_number' => 'nullable|max:7',
            'Interior_number' => 'nullable|max:7',
            'Cp' => 'nullable|numeric|digits:5',
            'locality' => 'nullable|min:5|max:85',
        ];

        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'insured' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }
        DB::beginTransaction();
        try {
            $insured = new Insured();
            $insured->subdependency_id = $request->input('Subdependency_id');
            $insured->rank_id = $request->input('Rank_id');
            $insured->workplace_county_id = $request->input('Workplace_county_id');
            $insured->birthplace_county_id = $request->input('Birthplace_county_id');
            $insured->affiliation_status_id = $request->input('Affiliation_status_id');
            $insured->county_id = $request->input('County_id');
            $insured->file_number = Str::of($request->input('File_number'))->trim();
            $insured->employee_number = Str::of($request->input('Employee_number'))->trim();
            $insured->name = Str::of($request->input('Name'))->trim();
            $insured->last_name_1 = Str::of($request->input('Last_name_1'))->trim();
            $insured->last_name_2 = Str::of($request->input('Last_name_2'))->trim();
            $insured->sex = $request->input('Sex');
            $insured->birthday = $request->input('Birthday');
            $insured->blood_type = $request->input('Blood_type');
            $rfc = Str::of($request->input('Rfc'))->trim();
            $insured->rfc = Str::upper($rfc);
            $curp = Str::of($request->input('Curp'))->trim();
            $insured->curp = Str::upper($curp) ?: null;
            $insured->marital_status = $request->input('Marital_status');
            $insured->phone = Str::of($request->input('Phone'))->trim() ?: null;
            $email = Str::of($request->input('Email'))->trim();
            $insured->email = Str::lower($email) ?: null;
            $insured->neighborhood = Str::of($request->input('Neighborhood'))->trim() ?: null;
            $insured->roadway_type = Str::of($request->input('Roadway_type'))->trim() ?: null;
            $insured->street = Str::of($request->input('Street'))->trim() ?: null;
            $insured->outdoor_number = Str::of($request->input('Outdoor_number'))->trim() ?: null;
            $insured->interior_number = Str::of($request->input('Interior_number'))->trim() ?: null;
            $insured->cp = Str::of($request->input('Cp'))->trim() ?: null;
            $insured->locality = Str::of($request->input('Locality'))->trim() ?: null;
            $insured->start_date = $request->input('Start_date');
            $insured->register_motive = Str::of($request->input('Register_motive'))->trim() ?: null;
            $insured->observations = Str::of($request->input('Observations'))->trim() ?: null;
            $insured->status = 'active';
            $insured->modified_by = Auth::user()->email;
            $insured->save();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Registro guardado correctamente',
                'insured' => $insured,
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
            'Subdependency_id' => 'required',
            'Rank_id' => 'required',
            'Workplace_county_id' => 'nullable',
            'Birthplace_county_id' => 'nullable',
            'Affiliation_status_id' => 'required',
            'County_id' => 'nullable',
            'Employee_number' => 'required|min:6|max:6|unique:insureds,employee_number,' . $id,
            'Start_date' => 'required|date|max:10',
            'Register_motive' => 'nullable|min:3|max:250',
            'Observations' => 'nullable|min:5|max:250',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Birthday' => 'nullable|max:10|date',
            'Sex' => 'required',
            'Marital_status' => 'nullable',
            'Rfc' => 'required|max:13|alpha_num:ascii',
            'Curp' => 'nullable | string | min:18 | max: 18',
            'Phone' => 'nullable|numeric|digits:10',
            'Email' => 'nullable|email|min:5|max:50|unique:insureds,email',
            'Neighborhood' => 'nullable|min:5|max:50',
            'Roadway_type' => 'nullable|min:5|max:50',
            'Street' => 'nullable|min:5|max:50',
            'Outdoor_number' => 'nullable|max:7',
            'Interior_number' => 'nullable|max:7',
            'Cp' => 'nullable|numeric|digits:5',
            'locality' => 'nullable|min:5|max:85',
        ];

        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'insured' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $insured = Insured::find($id);
            $insured->subdependency_id = $request->input('Subdependency_id');
            $insured->rank_id = $request->input('Rank_id');
            $insured->workplace_county_id = $request->input('Workplace_county_id');
            $insured->birthplace_county_id = $request->input('Birthplace_county_id');
            $insured->affiliation_status_id = $request->input('Affiliation_status_id');
            $insured->county_id = $request->input('County_id');
            $insured->employee_number = Str::of($request->input('Employee_number'))->trim();
            $insured->name = Str::of($request->input('Name'))->trim();
            $insured->last_name_1 = Str::of($request->input('Last_name_1'))->trim();
            $insured->last_name_2 = Str::of($request->input('Last_name_2'))->trim();
            $insured->sex = $request->input('Sex');
            $insured->birthday = $request->input('Birthday');
            $insured->blood_type = $request->input('Blood_type');
            $rfc = Str::of($request->input('Rfc'))->trim();
            $insured->rfc = Str::upper($rfc);
            $curp = Str::of($request->input('Curp'))->trim();
            $insured->curp = Str::upper($curp) ?: null;
            $insured->marital_status = $request->input('Marital_status');
            $insured->phone = Str::of($request->input('Phone'))->trim() ?: null;
            $email = Str::of($request->input('Email'))->trim();
            $insured->email = Str::lower($email) ?: null;
            $insured->neighborhood = Str::of($request->input('Neighborhood'))->trim() ?: null;
            $insured->roadway_type = Str::of($request->input('Roadway_type'))->trim() ?: null;
            $insured->street = Str::of($request->input('Street'))->trim() ?: null;
            $insured->outdoor_number = Str::of($request->input('Outdoor_number'))->trim() ?: null;
            $insured->interior_number = Str::of($request->input('Interior_number'))->trim() ?: null;
            $insured->cp = Str::of($request->input('Cp'))->trim() ?: null;
            $insured->locality = Str::of($request->input('Locality'))->trim() ?: null;
            $insured->start_date = $request->input('Start_date');
            $insured->register_motive = Str::of($request->input('Register_motive'))->trim() ?: null;
            $insured->observations = Str::of($request->input('Observations'))->trim() ?: null;
            $insured->modified_by = Auth::user()->email;
            $insured->save();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Registro  actualizado correctamente',
                'insured' => $insured,
            ], 201);
        } catch (\Exception $e) {
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
                'rank',
                'workplaceCounty',
                'birthplaceCounty',
                'affiliationStatus',
                'county.state',
                'beneficiaries'
            ];

            $insureds = Insured::with($relations)
                ->where(function ($query) use ($data) {
                $query->where('file_number', 'like', "%{$data}%")
                      ->orWhere('rfc', 'like', "%{$data}%")
                      ->orWhere('curp', 'like', "%{$data}%")
                      ->orWhere(DB::raw("CONCAT(last_name_1, ' ', last_name_2, ' ', name)"), 'like', "%{$data}%")
                      ->orWhere(DB::raw("CONCAT(name,' ',last_name_1, ' ', last_name_2)"), 'like', "%{$data}%");
                })
                ->get();

            if ($insureds->isEmpty()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'insureds' => null,
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'insureds' => $insureds,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function searchByFolio(Request $request, $folio)
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
                ->where('file_number', $folio)
                ->where('affiliation_status_id', '!=', 4)
                ->first();

            $history = Insured::with($relations)
                ->where('file_number', $folio)
                ->where('affiliation_status_id', 4)
                ->get();

            if (!$insured && !$history) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'insured' => null,
                    'history' => null,
                ], 404);
            }
            //sleep(33);
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'insured' => $insured,
                'history' => $history,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function searchByRfc(Request $request, $rfc)
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
                ->where('file_number', $rfc)
                ->where('affiliation_status_id', '!=', 4)
                ->first();

            $history = Insured::with($relations)
                ->where('file_number', $rfc)
                ->where('affiliation_status_id', 4)
                ->get();

            if (!$insured && !$history) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'insured' => null,
                    'history' => null,
                ], 404);
            }
            //sleep(33);
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'insured' => $insured,
                'history' => $history,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function searchByCurp(Request $request, $curp)
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
                ->where('file_number', $curp)
                ->where('affiliation_status_id', '!=', 4)
                ->first();

            $history = Insured::with($relations)
                ->where('file_number', $curp)
                ->where('affiliation_status_id', 4)
                ->get();

            if (!$insured && !$history) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'insured' => null,
                    'history' => null,
                ], 404);
            }
            //sleep(33);
            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'insured' => $insured,
                'history' => $history,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }    
    public function deactivate(Request $request, $id)
    {
        $rules = [
            'File_number' => 'required|max:8',
            'Inactive_date' => 'required|date',
            'Inactive_date_dependency' => 'required|date',
            'Inactive_motive' => 'required',
            'Inactive_reference' => 'nullable|max:250',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'insured' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $insured = Insured::findOrFail($id);
            $fecha_baja = $request->input('Inactive_date');
            $baja_dependencia = $request->input('Inactive_date_dependency');
            $motivo_baja = Str::of($request->input('Inactive_motive'))->trim();
            $referencia = Str::of($request->input('Inactive_reference'))->trim();
            if (!$insured) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Registro no encontrado',
                    'insured' => null,
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }
            $msj = '';
            if ($motivo_baja == 'Acta administrativa') {
                //$insured->inactive_date = $fecha_baja;
                $insured->inactive_date_dependency = $baja_dependencia;
                $insured->inactive_motive = $motivo_baja;
                $insured->inactive_reference = $referencia;
                //$insured->affiliate_status = 'Baja por aplicar';
                $insured->affiliation_status_id = 5;
                $insured->modified_by = Auth::user()->email;
                $insured->save();
                $affectedRows = Beneficiary::where('insured_id', $insured->id)->update([
                    //'inactive_date' => $fecha_baja,
                    'inactive_motive' => $motivo_baja . ' del titular',
                    'affiliate_status' => 'Baja por aplicar',
                    'modified_by' => Auth::user()->email,
                ]);

                $msj = ($affectedRows === 0) ?
                    'El registro ' . $insured->file_number . ' fue dado de baja con éxito, pero no se encontraron familiares para actualizar.' :
                    'El registro ' . $insured->file_number . ' y sus familiares fueron dados de baja con éxito!';
            } elseif ($motivo_baja == 'Defunsión') {
                $insured->inactive_date = $fecha_baja;
                $insured->inactive_date_dependency = $baja_dependencia;
                $insured->inactive_motive = $motivo_baja;
                $insured->inactive_reference = $referencia;
                //$insured->affiliate_status = 'Baja';
                $insured->affiliation_status_id = 4;
                $insured->modified_by = Auth::user()->email;
                $insured->save();
                $affectedRows = Beneficiary::where('insured_id', $insured->id)->update([
                    'inactive_date' => $fecha_baja,
                    'inactive_motive' => $motivo_baja . ' del titular',
                    'affiliate_status' => 'Baja por aplicar',
                    'modified_by' => Auth::user()->email,
                ]);

                $msj = ($affectedRows === 0) ?
                    'El registro ' . $insured->file_number . ' fue dado de baja con éxito, pero no se encontraron familiares para actualizar.' :
                    'El registro ' . $insured->file_number . ' y sus familiares fueron dados de baja con éxito!';
            } elseif ($motivo_baja == 'Pensión' || $motivo_baja == 'Renuncia voluntaria' || $motivo_baja == 'Cambio de cotización al IMSS') {
                $insured->inactive_date = $fecha_baja;
                $insured->inactive_date_dependency = $baja_dependencia;
                $insured->inactive_motive = $motivo_baja;
                $insured->inactive_reference = $referencia;
                //$insured->affiliate_status = 'Baja';
                $insured->affiliation_status_id = 4;
                $insured->modified_by = Auth::user()->email;
                $insured->save();
                $affectedRows = Beneficiary::where('insured_id', $insured->id)->update([
                    'inactive_date' => $fecha_baja,
                    'inactive_motive' => $motivo_baja . ' del titular',
                    'affiliate_status' => 'Baja',
                    'modified_by' => Auth::user()->email,
                ]);

                $msj = ($affectedRows === 0) ?
                    'El registro ' . $insured->file_number . ' fue dado de baja con éxito, pero no se encontraron familiares para actualizar.' :
                    'El registro ' . $insured->file_number . ' y sus familiares fueron dados de baja con éxito!';
            } else {
                throw new \Exception("Motivo de baja no reconocido: $motivo_baja");
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => $msj,
                'insured' => $insured,
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
    public function photo(Request $request, $id)
    {
        $rules = [
            'File_number' => 'required|string|max:8',
            'Photo' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'insured' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $insured = Insured::findOrFail($id);
            if (!$insured) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Registro no encontrado',
                    'insured' => null,
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }
            $insured->photo = Str::of($request->input('Photo'))->trim();
            $insured->modified_by = Auth::user()->email;
            $insured->save();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Registro actualizado correctamente',
                'insured' => $insured,
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
            'File_number' => 'required|string|max:8',
            'Signature' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'insured' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $insured = Insured::findOrFail($id);
            if (!$insured) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Registro no encontrado',
                    'insured' => null,
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }
            $insured->signature = Str::of($request->input('Signature'))->trim();
            $insured->modified_by = Auth::user()->email;
            $insured->save();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Registro actualizado correctamente',
                'insured' => $insured,
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
    public function reentry(Request $request)
    {

        $rules = [
            'Subdependency_id' => 'required',
            'Rank_id' => 'required',
            'Workplace_county_id' => 'nullable',
            'Birthplace_county_id' => 'nullable',
            'Affiliation_status_id' => 'required',
            'County_id' => 'nullable',
            //Valida si ya hay un registro en la tabla insureds con el mismo numero de afiliacion con un estatus de activo
            'File_number' => [
                'required',
                'max:8',
                Rule::unique('insureds')->where(fn(Builder $query) => $query->where('affiliation_status_id', 2)),
            ],
            'Employee_number' => 'required|min:6|max:6|unique:insureds,employee_number',
            'Start_date' => 'required|date|max:10',
            'Register_motive' => 'nullable|min:3|max:250',
            'Observations' => 'nullable|min:5|max:250',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Birthday' => 'nullable|max:10|date',
            'Sex' => 'required',
            'Marital_status' => 'nullable',
            'Rfc' => [
                'required',
                'alpha_num:ascii',
                Rule::unique('insureds')->where(fn(Builder $query) => $query->where('affiliation_status_id', 2)),
            ],
            'Curp' => 'nullable | string | min:18 | max: 18',
            'Phone' => 'nullable|numeric|digits:10',
            'Email' => 'nullable|email|min:5|max:50|unique:insureds,email',
            'Neighborhood' => 'nullable|min:5|max:50',
            'Roadway_type' => 'nullable|min:5|max:50',
            'Street' => 'nullable|min:5|max:50',
            'Outdoor_number' => 'nullable|max:7',
            'Interior_number' => 'nullable|max:7',
            'Cp' => 'nullable|numeric|digits:5',
            'locality' => 'nullable|min:5|max:85',
        ];

        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'insured' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }
        DB::beginTransaction();
        try {
            $insured = new Insured();
            $insured->subdependency_id = $request->input('Subdependency_id');
            $insured->rank_id = $request->input('Rank_id');
            $insured->workplace_county_id = $request->input('Workplace_county_id');
            $insured->birthplace_county_id = $request->input('Birthplace_county_id');
            $insured->affiliation_status_id = $request->input('Affiliation_status_id');
            $insured->county_id = $request->input('County_id');
            $insured->file_number = Str::of($request->input('File_number'))->trim();
            $insured->employee_number = Str::of($request->input('Employee_number'))->trim();
            $insured->name = Str::of($request->input('Name'))->trim();
            $insured->last_name_1 = Str::of($request->input('Last_name_1'))->trim();
            $insured->last_name_2 = Str::of($request->input('Last_name_2'))->trim();
            $insured->sex = $request->input('Sex');
            $insured->birthday = $request->input('Birthday');
            $insured->blood_type = $request->input('Blood_type');
            $rfc = Str::of($request->input('Rfc'))->trim();
            $insured->rfc = Str::upper($rfc);
            $curp = Str::of($request->input('Curp'))->trim();
            $insured->curp = Str::upper($curp) ?: null;
            $insured->marital_status = $request->input('Marital_status');
            $insured->phone = Str::of($request->input('Phone'))->trim() ?: null;
            $email = Str::of($request->input('Email'))->trim();
            $insured->email = Str::lower($email) ?: null;
            $insured->neighborhood = Str::of($request->input('Neighborhood'))->trim() ?: null;
            $insured->roadway_type = Str::of($request->input('Roadway_type'))->trim() ?: null;
            $insured->street = Str::of($request->input('Street'))->trim() ?: null;
            $insured->outdoor_number = Str::of($request->input('Outdoor_number'))->trim() ?: null;
            $insured->interior_number = Str::of($request->input('Interior_number'))->trim() ?: null;
            $insured->cp = Str::of($request->input('Cp'))->trim() ?: null;
            $insured->locality = Str::of($request->input('Locality'))->trim() ?: null;
            $insured->start_date = $request->input('Start_date');
            $hoy = Carbon::today();
            $insured->reentry_date = $hoy;
            $insured->register_motive = Str::of($request->input('Register_motive'))->trim() ?: null;
            $insured->observations = Str::of($request->input('Observations'))->trim() ?: null;
            $insured->status = 'active';
            $insured->modified_by = Auth::user()->email;
            $insured->save();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Registro guardado correctamente',
                'insured' => $insured,
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
