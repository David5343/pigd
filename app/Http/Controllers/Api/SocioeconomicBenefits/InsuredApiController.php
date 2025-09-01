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

class InsuredApiController extends Controller
{
    public function index()
    {
        $titulares = Insured::select([
            'id',
            'subdependency_id',
            'rank_id',
            'workplace_county_id',
            'birthplace_county_id',
            'county_id',
            'file_number',
            'employee_number',
            'name',
            'last_name_1',
            'last_name_2',
            'rfc',
            'curp',
            'start_date',
            'affiliate_status'
        ])->with('rank', 'subdependency')
            ->latest()
            ->limit(25)
            ->get();

        return response()->json($titulares);
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
            'beneficiaries'
        ];

        $insured = Insured::with($relations)
            ->where('id', $id)
            ->first();

        $history = Insured::with($relations)
            ->where('id', $id)
            ->where('affiliate_status', 'Baja')
            ->first();

        if (!$insured && !$history) {
            return response()->json([
                'status' => 'error',
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
            'status' => 'error',
            'message' => 'Error en el servidor',
            'error' => $e->getMessage(),
        ], 500);
    }
    }

    public function idgenerator()
    {
        $no_afiliacion = IdGenerator::generate(['table' => 'insureds', 'field' => 'file_number', 'length' => 8, 'prefix' => 'T']);
        $response['no_afiliacion'] = $no_afiliacion;

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $response['status'] = 'fail';
        $response['errors'] = '';
        $response['insured'] = '';
        $response['debug'] = '';
        $rules = [
            'Subdependency_id' => 'required',
            'Rank_id' => 'required',
            'Workplace_county_id' => 'nullable',
            'Birthplace_county_id' => 'nullable',
            'County_id' => 'nullable',
            //'File_number' => 'required|max:8|unique:insureds,file_number',
            //'File_number' => ['required',Rule::unique('insureds')->where(fn (Builder $query) => $query->where('affiliate_status','Activo'))],
            //Valida si ya hay un registro en la tabla insureds con el mismo numero de afiliacion con un estatus de activo
            'File_number' => [
                'required',
                'max:8',
                Rule::unique('insureds')->where(fn(Builder $query) => $query->where('affiliate_status', 'Activo')),
            ],
            'Employee_number' => 'required|min:6|max:6|unique:insureds,employee_number',
            'Start_date' => 'required|date|max:10',
            // 'Work_place' => 'nullable|min:3|max:85',
            'Register_motive' => 'nullable|min:3|max:250',
            'Affiliate_status' => 'required|not_in:Elije...',
            'Observations' => 'nullable|min:5|max:250',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Blood_type' => 'required',
            'Birthday' => 'nullable|max:10|date',
            // 'Birthplace' => 'nullable|min:3|max:85',
            'Sex' => 'required',
            'Marital_status' => 'nullable',
            //'Rfc' => 'required|max:13|alpha_num:ascii|unique:insureds,rfc',
            //'Rfc' => 'required|max:13|alpha_num:ascii',
            'Rfc' => [
                'required',
                'alpha_num:ascii',
                Rule::unique('insureds')->where(fn(Builder $query) => $query->where('affiliate_status', 'Activo')),
            ],
            //'Curp' => 'nullable| max:18 |alpha_num:ascii|unique:insureds,curp',
            // 'Curp' => ['nullable| max:18 |min:18|alpha_num:ascii',
            // Rule::unique('insureds')->where(fn (Builder $query) => $query->where('affiliate_status','Activo'))],
            'Curp' => 'nullable | string | min:18 | max: 18',
            'Phone' => 'nullable|numeric|digits:10',
            'Email' => 'nullable|email|min:5|max:50|unique:insureds,email',
            // 'State' => 'nullable|min:5|max:85',
            // 'County' => 'nullable|min:3|max:85',
            'Neighborhood' => 'nullable|min:5|max:50',
            'Roadway_type' => 'nullable|min:5|max:50',
            'Street' => 'nullable|min:5|max:50',
            'Outdoor_number' => 'nullable|max:7',
            'Interior_number' => 'nullable|max:7',
            'Cp' => 'nullable|numeric|digits:5',
            'locality' => 'nullable|min:5|max:85',
        ];
        // $messages = [
        //     'File_number.required' => 'El número de expediente es obligatorio.',
        //     'File_number.max' => 'El número de expediente no debe exceder los 8 caracteres.',
        //     'File_number.unique' => 'El número de expediente ya está registrado para un afiliado activo.',
        //     'Subdependency_id.required' => 'La subdependencia es obligatoria.',
        //     'Subdependency_id.numeric' => 'La subdependencia debe ser un número.',
        //     'Subdependency_id.min' => 'La subdependencia debe ser al menos 1.',
        //     // Añade aquí el resto de tus mensajes personalizados...
        //     'Rfc.required' => 'El RFC es obligatorio.',
        //     'Rfc.alpha_num' => 'El RFC debe ser alfanumérico.',
        //     'Rfc.unique' => 'El RFC ya está registrado para un afiliado activo.',
        //     'Curp.alpha_num' => 'La CURP debe ser alfanumérica.',
        //     'Curp.unique' => 'La CURP ya está registrada para un afiliado activo.',
        //     'Email.email' => 'El correo electrónico debe ser una dirección válida.',
        //     'Email.unique' => 'El correo electrónico ya está registrado.',
        //     // etc...
        // ];
        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            $response['errors'] = $validator->errors()->toArray();

            //$response['errors'] = $validator->errors();
            //$response['debug'] = $request->all();
            return response()->json($response, 200);
        }

        // Si la validación pasa, continua con el resto de tu lógica aquí
        DB::beginTransaction();
        try {

            $titular = new Insured();
            $titular->subdependency_id = $request->input('Subdependency_id');
            $titular->rank_id = $request->input('Rank_id');
            $titular->workplace_county_id = $request->input('Workplace_county_id');
            $titular->birthplace_county_id = $request->input('Birthplace_county_id');
            $titular->county_id = $request->input('County_id');
            $titular->file_number = Str::of($request->input('File_number'))->trim();
            $titular->employee_number = Str::of($request->input('Employee_number'))->trim();
            $titular->name = Str::of($request->input('Name'))->trim();
            $titular->last_name_1 = Str::of($request->input('Last_name_1'))->trim();
            $titular->last_name_2 = Str::of($request->input('Last_name_2'))->trim();
            $titular->sex = $request->input('Sex');
            $titular->birthday = $request->input('Birthday');
            $titular->blood_type = $request->input('Blood_type');
            // $titular->birthplace = Str::of($request->input('Birthplace'))->trim();       
            $rfc = Str::of($request->input('Rfc'))->trim();
            $titular->rfc = Str::upper($rfc);
            $curp = Str::of($request->input('Curp'))->trim();
            $titular->curp = Str::upper($curp) ?: null;
            $titular->marital_status = $request->input('Marital_status');
            $titular->phone = Str::of($request->input('Phone'))->trim() ?: null;
            $email = Str::of($request->input('Email'))->trim();
            $titular->email = Str::lower($email) ?: null;
            // $titular->state = Str::of($request->input('State'))->trim();
            // $titular->county = Str::of($request->input('County'))->trim();
            $titular->neighborhood = Str::of($request->input('Neighborhood'))->trim() ?: null;
            $titular->roadway_type = Str::of($request->input('Roadway_type'))->trim() ?: null;
            $titular->street = Str::of($request->input('Street'))->trim() ?: null;
            $titular->outdoor_number = Str::of($request->input('Outdoor_number'))->trim() ?: null;
            $titular->interior_number = Str::of($request->input('Interior_number'))->trim() ?: null;
            $titular->cp = Str::of($request->input('Cp'))->trim() ?: null;
            $titular->locality = Str::of($request->input('Locality'))->trim() ?: null;
            $titular->start_date = $request->input('Start_date');
            // $titular->work_place = Str::of($request->input('Work_place'))->trim();
            $titular->register_motive = Str::of($request->input('Register_motive'))->trim() ?: null;
            $titular->affiliate_status = $request->input('Affiliate_status');
            $titular->observations = Str::of($request->input('Observations'))->trim() ?: null;
            $titular->status = 'active';
            $titular->modified_by = Auth::user()->email;
            $titular->save();
            DB::commit();
            $response['status'] = 'success';
            $response['insured'] = $titular->file_number;

            return response()->json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            $response['debug'] = $e->getMessage();
        }
    }
    public function update(Request $request, $id)
    {
        $todo = $request->all();
        $codigo = 0;
        $response['status'] = 'fail';
        $response['errors'] = '';
        $response['insured'] = '';
        $response['debug'] = '';
        //$response['debug'] =$request->input('File_number');
        //$codigo = 200;
        //return response()->json($response,status:$codigo);
        $rules = [
            'Subdependency_id' => 'required',
            'Rank_id' => 'required',
            'Workplace_county_id' => 'nullable',
            'Birthplace_county_id' => 'nullable',
            'County_id' => 'nullable',
            'Employee_number' => 'required|min:6|max:6|unique:insureds,employee_number,' . $id,
            'Start_date' => 'required|date|max:10',
            // 'Work_place' => 'nullable|min:3|max:85',
            'Register_motive' => 'nullable|min:3|max:250',
            'Affiliate_status' => 'required|not_in:Elije...',
            'Observations' => 'nullable|min:5|max:250',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Blood_type' => 'required',
            'Birthday' => 'nullable|max:10|date',
            // 'Birthplace' => 'nullable|min:3|max:85',
            'Sex' => 'required',
            'Marital_status' => 'nullable',
            'Rfc' => 'required|max:13|alpha_num:ascii',
            'Curp' => 'nullable | string | min:18 | max: 18',
            'Phone' => 'nullable|numeric|digits:10',
            'Email' => 'nullable|email|min:5|max:50|unique:insureds,email',
            // 'State' => 'nullable|min:5|max:85',
            // 'County' => 'nullable|min:3|max:85',
            'Neighborhood' => 'nullable|min:5|max:50',
            'Roadway_type' => 'nullable|min:5|max:50',
            'Street' => 'nullable|min:5|max:50',
            'Outdoor_number' => 'nullable|max:7',
            'Interior_number' => 'nullable|max:7',
            'Cp' => 'nullable|numeric|digits:5',
            'locality' => 'nullable|min:5|max:85',
        ];
        // $messages = [
        //     'File_number.required' => 'El número de expediente es obligatorio.',
        //     'File_number.max' => 'El número de expediente no debe exceder los 8 caracteres.',
        //     'File_number.unique' => 'El número de expediente ya está registrado para un afiliado activo.',
        //     'Subdependency_id.required' => 'La subdependencia es obligatoria.',
        //     'Subdependency_id.numeric' => 'La subdependencia debe ser un número.',
        //     'Subdependency_id.min' => 'La subdependencia debe ser al menos 1.',
        //     // Añade aquí el resto de tus mensajes personalizados...
        //     'Rfc.required' => 'El RFC es obligatorio.',
        //     'Rfc.alpha_num' => 'El RFC debe ser alfanumérico.',
        //     'Rfc.unique' => 'El RFC ya está registrado para un afiliado activo.',
        //     'Curp.alpha_num' => 'La CURP debe ser alfanumérica.',
        //     'Curp.unique' => 'La CURP ya está registrada para un afiliado activo.',
        //     'Email.email' => 'El correo electrónico debe ser una dirección válida.',
        //     'Email.unique' => 'El correo electrónico ya está registrado.',
        //     // etc...
        // ];
        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            $response['errors'] = $validator->errors()->toArray();
            //$response['debug'] = [$request->all()];
            $codigo = 200;

            return response()->json($response, status: $codigo);
        }

        // Si la validación pasa, continua con el resto de tu lógica aquí
        DB::beginTransaction();
        try {
            //$id = $request->input('Id');
            $titular = Insured::find($id);
            $titular->subdependency_id = $request->input('Subdependency_id');
            $titular->rank_id = $request->input('Rank_id');
            $titular->workplace_county_id = $request->input('Workplace_county_id');
            $titular->birthplace_county_id = $request->input('Birthplace_county_id');
            $titular->county_id = $request->input('County_id');
            $titular->employee_number = Str::of($request->input('Employee_number'))->trim();
            $titular->name = Str::of($request->input('Name'))->trim();
            $titular->last_name_1 = Str::of($request->input('Last_name_1'))->trim();
            $titular->last_name_2 = Str::of($request->input('Last_name_2'))->trim();
            $titular->sex = $request->input('Sex');
            $titular->birthday = $request->input('Birthday');
            $titular->blood_type = $request->input('Blood_type');
            // $titular->birthplace = Str::of($request->input('Birthplace'))->trim();       
            $rfc = Str::of($request->input('Rfc'))->trim();
            $titular->rfc = Str::upper($rfc);
            $curp = Str::of($request->input('Curp'))->trim();
            $titular->curp = Str::upper($curp) ?: null;
            $titular->marital_status = $request->input('Marital_status');
            $titular->phone = Str::of($request->input('Phone'))->trim() ?: null;
            $email = Str::of($request->input('Email'))->trim();
            $titular->email = Str::lower($email) ?: null;
            // $titular->state = Str::of($request->input('State'))->trim();
            // $titular->county = Str::of($request->input('County'))->trim();
            $titular->neighborhood = Str::of($request->input('Neighborhood'))->trim() ?: null;
            $titular->roadway_type = Str::of($request->input('Roadway_type'))->trim() ?: null;
            $titular->street = Str::of($request->input('Street'))->trim() ?: null;
            $titular->outdoor_number = Str::of($request->input('Outdoor_number'))->trim() ?: null;
            $titular->interior_number = Str::of($request->input('Interior_number'))->trim() ?: null;
            $titular->cp = Str::of($request->input('Cp'))->trim() ?: null;
            $titular->locality = Str::of($request->input('Locality'))->trim() ?: null;
            $titular->start_date = $request->input('Start_date');
            // $titular->work_place = Str::of($request->input('Work_place'))->trim();
            $titular->register_motive = Str::of($request->input('Register_motive'))->trim() ?: null;
            $titular->affiliate_status = $request->input('Affiliate_status');
            $titular->observations = Str::of($request->input('Observations'))->trim() ?: null;
            $titular->status = 'active';
            $titular->modified_by = Auth::user()->email;
            $titular->save();
            DB::commit();
            $response['status'] = 'success';
            $response['message'] = $titular->file_number;
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } catch (Exception $e) {
            DB::rollBack();
            $response['debug'] = $e->getMessage();
        }
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
        $titular = Insured::where('id', $dato)
            ->orwhere('file_number', $dato)
            ->orwhere('rfc', $dato)
            ->orwhere('curp', $dato)
            ->orwhere('name', 'like', '%' . $dato . '%')
            ->orwhere('last_name_1', 'like', '%' . $dato . '%')
            ->orwhere('last_name_2', 'like', '%' . $dato . '%')
            ->with('subdependency')
            ->with('rank')
            ->with('beneficiaries')
            ->get();
        if ($titular->isEmpty()) {
            $response['message'] = 'Registro no encontrado';
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } else {
            $response['status'] = 'success';
            $response['insured'] = $titular;
            $codigo = 200;

            return response()->json($response, status: $codigo);
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
            'county',
            'beneficiaries'
        ];

        $insured = Insured::with($relations)
            ->where('file_number', $data)
            ->first();

        $history = Insured::with($relations)
            ->where('file_number', $data)
            ->where('affiliate_status', 'Baja')
            ->first();

        if (!$insured && !$history) {
            return response()->json([
                'status' => 'error',
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
            'status' => 'error',
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
            'beneficiaries'
        ];

        $insured = Insured::with($relations)
            ->where('file_number', $folio)
            ->first();

        $history = Insured::with($relations)
            ->where('file_number', $folio)
            ->where('affiliate_status', 'Baja')
            ->first();

        if (!$insured && !$history) {
            return response()->json([
                'status' => 'error',
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
            'status' => 'error',
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
            'beneficiaries'
        ];

        $insured = Insured::with($relations)
            ->where('rfc', $rfc)
            ->first();

        $history = Insured::with($relations)
            ->where('rfc', $rfc)
            ->where('affiliate_status', 'Baja')
            ->first();

        if (!$insured && !$history) {
            return response()->json([
                'status' => 'error',
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
            'status' => 'error',
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
            'beneficiaries'
        ];

        $insured = Insured::with($relations)
            ->where('curp', $curp)
            ->first();

        $history = Insured::with($relations)
            ->where('curp', $curp)
            ->where('affiliate_status', 'Baja')
            ->first();

        if (!$insured && !$history) {
            return response()->json([
                'status' => 'error',
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
            'status' => 'error',
            'message' => 'Error en el servidor',
            'error' => $e->getMessage(),
        ], 500);
    }
}
    public function baja(Request $request)
    {
        $response = [
            'Status' => 'fail',
            'Message' => '',
            'Errors' => '',
            'Insured' => '',
            'Debug' => '',
        ];

        $rules = [
            'File_number' => 'required|max:8',
            'Inactive_date' => 'required|date',
            'Inactive_date_dependency' => 'required|date',
            'Inactive_motive' => 'required',
            'Inactive_reference' => 'nullable|max:250',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['Status'] = 'fail';
            $response['Errors'] = $validator->errors()->toArray();
            return response()->json($response, 200);
        }

        DB::beginTransaction();
        try {
            $fecha_baja = $request->input('Inactive_date');
            $baja_dependencia = $request->input('Inactive_date_dependency');
            $motivo_baja = Str::of($request->input('Inactive_motive'))->trim();
            $referencia = Str::of($request->input('Inactive_reference'))->trim();
            $id = $request->input('Id');
            $titular = Insured::find($id);
            if (!$titular) {
                $response['Status'] = 'success';
                $response['Message'] = "Titular no encontrado";
                $response['Debug'] = $id;
                return response()->json($response, 200);
            }

            if ($motivo_baja == 'Acta administrativa') {
                $titular->inactive_date = $request->input('Inactive_date');
                $titular->inactive_date_dependency = $baja_dependencia;
                $titular->inactive_motive = $motivo_baja;
                $titular->inactive_reference = $referencia;
                $titular->affiliate_status = 'Baja por aplicar';
                $titular->modified_by = Auth::user()->email;
                $titular->save();
                $affectedRows = Beneficiary::where('insured_id', $titular->id)->update([
                    'inactive_date' => $fecha_baja,
                    'inactive_motive' => $motivo_baja . ' del titular',
                    'affiliate_status' => 'Baja por aplicar',
                    'modified_by' => Auth::user()->email,
                ]);

                $response['Message'] = ($affectedRows === 0) ?
                    'El registro ' . $titular->file_number . ' fue dado de baja con éxito, pero no se encontraron familiares para actualizar.' :
                    'El registro ' . $titular->file_number . ' y sus familiares fueron dados de baja con éxito!';
            } elseif ($motivo_baja == 'Defunsión') {
                $titular->inactive_date = $fecha_baja;
                $titular->inactive_date_dependency = $baja_dependencia;
                $titular->inactive_motive = $motivo_baja;
                $titular->inactive_reference = $referencia;
                $titular->affiliate_status = 'Baja';
                $titular->modified_by = Auth::user()->email;
                $titular->save();
                $affectedRows = Beneficiary::where('insured_id', $titular->id)->update([
                    'inactive_date' => $fecha_baja,
                    'inactive_motive' => $motivo_baja . ' del titular',
                    'affiliate_status' => 'Baja por Aplicar',
                    'modified_by' => Auth::user()->email,
                ]);

                $response['Message'] = ($affectedRows === 0) ?
                    'El registro ' . $titular->file_number . ' fue dado de baja con éxito, pero no se encontraron familiares para actualizar.' :
                    'El registro ' . $titular->file_number . ' y sus familiares fueron dados de baja con éxito!';
            } elseif ($motivo_baja == 'Pensión' || $motivo_baja == 'Renuncia voluntaria') {
                $titular->inactive_date = $fecha_baja;
                $titular->inactive_date_dependency = $baja_dependencia;
                $titular->inactive_motive = $motivo_baja;
                $titular->inactive_reference = $referencia;
                $titular->affiliate_status = 'Baja';
                $titular->modified_by = Auth::user()->email;
                $titular->save();
                $affectedRows = Beneficiary::where('insured_id', $titular->id)->update([
                    'inactive_date' => $fecha_baja,
                    'inactive_motive' => $motivo_baja . ' del titular',
                    'affiliate_status' => 'Baja',
                    'modified_by' => Auth::user()->email,
                ]);

                $response['Message'] = ($affectedRows === 0) ?
                    'El registro ' . $titular->file_number . ' fue dado de baja con éxito, pero no se encontraron familiares para actualizar.' :
                    'El registro ' . $titular->file_number . ' y sus familiares fueron dados de baja con éxito!';
            } else {
                throw new \Exception("Motivo de baja no reconocido: $motivo_baja");
            }
            DB::commit();
            $response['Status'] = 'success';
            return response()->json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            $response['debug'] = $e->getMessage();
            return response()->json($response, status: 500);
        }
    }

    public function guardarfoto(Request $request)
    {
        $response['Status'] = 'fail';
        $response['Message'] = '';
        $response['Errors'] = '';
        $response['Insured'] = '';
        $response['History'] = '';
        $response['debug'] = '';

        // Validación de la solicitud
        $validator = Validator::make($request->all(), [
            'File_number' => 'required|string|max:8',
            'Photo' => 'required|string'
        ]);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            $response['Errors'] = $validator->errors()->toArray();
            //$response['debug'] = [$request->all()];
            return response()->json($response);
        }

        // Si la validación pasa, continua con el resto de tu lógica aquí
        DB::beginTransaction();
        try {
            $titular = Insured::find($request->input('Id'));
            if ($titular == null) {
                $response['Message'] = 'Registro no encontrado';
                return response()->json($response);
            } else {
                $titular->photo = Str::of($request->input('Photo'))->trim();
                $titular->modified_by = Auth::user()->email;
                $titular->save();
                DB::commit();
                $response['Status'] = 'success';
                $response['Message'] = $titular->file_number;
                return response()->json($response);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $response['debug'] = $e->getMessage();
        }
    }
    public function guardarfirma(Request $request, $id)
    {
        $todo = $request->all();
        $codigo = 0;
        $response['status'] = 'fail';
        $response['message'] = '';
        $response['errors'] = '';
        $response['insured'] = '';
        $response['beneficiary'] = '';
        $response['history'] = '';
        $response['debug'] = '';
        $rules = [

            'File_number' => 'required',
            'max:8',
            'Signature' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            $response['errors'] = $validator->errors()->toArray();
            //$response['debug'] = [$request->all()];
            $codigo = 200;

            return response()->json($response, status: $codigo);
        }

        // Si la validación pasa, continua con el resto de tu lógica aquí
        DB::beginTransaction();
        try {
            $titular = Insured::find($id);
            if ($titular == null) {
                $response['message'] = 'Registro no encontrado';
                $codigo = 200;

                return response()->json($response, status: $codigo);
            } else {
                $titular->signature = Str::of($request->input('Signature'))->trim();
                $titular->modified_by = Auth::user()->email;
                $titular->save();
                DB::commit();
                $response['status'] = 'success';
                $response['message'] = $titular->file_number;
                $codigo = 200;

                return response()->json($response, status: $codigo);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $response['debug'] = $e->getMessage();
        }
    }
}
