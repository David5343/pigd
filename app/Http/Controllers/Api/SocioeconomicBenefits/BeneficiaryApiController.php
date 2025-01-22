<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class BeneficiaryApiController extends Controller
{
    public function idgenerator()
    {
        $no_afiliacion = IdGenerator::generate(['table' => 'beneficiaries', 'field' => 'file_number', 'length' => 8, 'prefix' => 'F']);
        $response['no_afiliacion'] = $no_afiliacion;

        return response()->json($response);
    }

    public function index()
    {
        $familiares = Beneficiary::with('bank')
            ->with('insured')
            ->latest()
            ->limit(25)
            ->get();

        return response()->json($familiares);
    }

    public function show($id)
    {
        $response['Status'] = 'fail';
        $response['Message'] = null;
        $response['Errors'] = null;
        $response['Beneficiary'] = null;
        $response['History'] = null;
        $response['Debug'] = null;
        $familiar = Beneficiary::where('id', $id)
            ->with('insured.subdependency')
            ->first();
        if ($familiar == null) {
            $response['message'] = 'Registro no encontrado';

            return response()->json($response, 200);
        } else {
            $history = Beneficiary::where('file_number', $familiar->file_number)
                ->where('affiliate_status', 'Baja')
                ->with('insured.subdependency')
                ->get();
            $response['Status'] = 'success';
            $response['Beneficiary'] = $familiar;
            if ($history != null) {
                $response['History'] = $history;
            }

            return response()->json($response, 200);
        }
    }

    public function store(Request $request)
    {
        $response['status'] = 'fail';
        $response['errors'] = '';
        $response['beneficiary'] = '';
        $response['debug'] = '';
        $rules = [
            //Valida si ya hay un registro en la tabla beneficiaries con el mismo numero de afiliacion con un estatus de activo
            'File_number' => [
                'required', 'max:8',
                Rule::unique('beneficiaries')->where(fn (Builder $query) => $query->where('affiliate_status', 'Activo')),
            ],
            'Insured_id' => 'required',
            'Start_date' => 'required|date|max:10',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Birthday' => 'nullable|max:10|date',
            'Sex' => 'required',
            'Rfc' => 'nullable | string | min:13 | max: 13',
            'Curp' => 'nullable | string | min:18 | max: 18',
            'Disabled_person' => 'nullable | string',
            'Relationship' => 'nullable | string',
            'Address' => 'nullable | string|max:200',
            'Observations' => 'nullable|min:5|max:180',
            'Account_number' => 'nullable|digits:10|unique:insureds,account_number',
            'Clabe' => 'nullable', 'digits:18', 'unique:insureds,clabe',
            'Bank_id' => 'nullable',
            'Representative_name' => 'nullable|max:40',
            'Representative_rfc' => 'nullable | max:13|alpha_num:ascii',
            'Representative_curp' => 'nullable | max:18|alpha_num:ascii',
            'Representative_relationship' => 'nullable',
        ];
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

            $familiar = new Beneficiary();
            $familiar->file_number = Str::of($request->input('File_number'))->trim();
            $familiar->insured_id = $request->input('Insured_id');
            $familiar->start_date = $request->input('Start_date');
            $familiar->last_name_1 = Str::of($request->input('Last_name_1'))->trim();
            $familiar->last_name_2 = Str::of($request->input('Last_name_2'))->trim();
            $familiar->name = Str::of($request->input('Name'))->trim();
            $familiar->birthday = $request->input('Birthday');
            $familiar->sex = $request->input('Sex');
            $rfc = Str::of($request->input('Rfc'))->trim();
            $familiar->rfc = Str::upper($rfc);
            $curp = Str::of($request->input('Curp'))->trim();
            $familiar->curp = Str::upper($curp);
            $familiar->disabled_person = Str::of($request->input('Disabled_person'))->trim();
            $familiar->relationship = Str::of($request->input('Relationship'))->trim();
            $familiar->address = Str::of($request->input('Address'))->trim();
            $familiar->observations = Str::of($request->input('Observations'))->trim();
            $familiar->clabe = Str::of($request->input('Clabe'))->trim();
            $familiar->bank_id = $request->input('Bank_id');
            $familiar->representative_name = Str::of($request->input('Representative_name'))->trim();
            $familiar->representative_rfc = Str::of($request->input('Representative_rfc'))->trim();
            $familiar->representative_curp = Str::of($request->input('Representative_curp'))->trim();
            $familiar->representative_relationship = Str::of($request->input('Representative_relationship'))->trim();
            $familiar->affiliate_status = 'Activo';
            $familiar->status = 'active';
            $familiar->modified_by = Auth::user()->email;
            $familiar->save();
            DB::commit();
            $response['status'] = 'success';
            $response['beneficiary'] = $familiar->file_number;

            return response()->json($response, 200);
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
        $familiar = Beneficiary::where('id', $dato)
            ->orwhere('file_number', $dato)
            ->orwhere('rfc', $dato)
            ->orwhere('curp', $dato)
            ->orwhere('name', 'like', '%'.$dato.'%')
            ->orwhere('last_name_1', 'like', '%'.$dato.'%')
            ->orwhere('last_name_2', 'like', '%'.$dato.'%')
            ->with('bank')
            ->with('insured')
            ->get();
        if ($familiar->isEmpty()) {
            $response['message'] = 'Registro no encontrado';
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } else {
            $response['status'] = 'success';
            $response['beneficiary'] = $familiar;
            $codigo = 200;

            return response()->json($response, status: $codigo);
        }
    }

    public function porfolio(Request $request)
    {
        $dato = $request->dato;
        $codigo = 0;
        $response['status'] = 'fail';
        $response['message'] = '';
        $response['errors'] = '';
        $response['insured'] = '';
        $response['beneficiary'] = '';
        $response['debug'] = '0';
        $familiar = Beneficiary::where('affiliate_status', 'Activo')
            ->where('file_number', $dato)
            ->with('bank')
            ->with('insured')
            ->first();
        if ($familiar == null) {
            $response['message'] = 'Registro no encontrado';
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } else {
            $response['status'] = 'success';
            $response['beneficiary'] = [$familiar];
            $codigo = 200;

            return response()->json($response, status: $codigo);
        }
    }

    public function porrfc(Request $request)
    {
        $dato = $request->dato;
        $codigo = 0;
        $response['status'] = 'fail';
        $response['message'] = '';
        $response['errors'] = '';
        $response['insured'] = '';
        $response['beneficiary'] = '';
        $response['debug'] = '0';
        $familiar = Beneficiary::where('affiliate_status', 'Activo')
            ->where('rfc', $dato)
            ->with('bank')
            ->with('insured')
            ->first();
        if ($familiar == null) {
            $response['message'] = 'Registro no encontrado';
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } else {
            $response['status'] = 'success';
            $response['beneficiary'] = $familiar;
            $codigo = 200;

            return response()->json($response, status: $codigo);
        }
    }

    public function porcurp(Request $request)
    {
        $dato = $request->dato;
        $codigo = 0;
        $response['status'] = 'fail';
        $response['message'] = '';
        $response['errors'] = '';
        $response['insured'] = '';
        $response['beneficiary'] = '';
        $response['debug'] = '0';
        $familiar = Beneficiary::where('affiliate_status', 'Activo')
            ->where('curp', $dato)
            ->with('bank')
            ->with('insured')
            ->first();
        if ($familiar == null) {
            $response['message'] = 'Registro no encontrado';
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } else {
            $response['status'] = 'success';
            $response['beneficiary'] = $familiar;
            $codigo = 200;

            return response()->json($response, status: $codigo);
        }
    }

    public function guardarfoto(Request $request, $id)
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

            'File_number' => 'required', 'max:8',
            'Photo' => 'required',
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
            $familiar = Beneficiary::find($id);
            if ($familiar == null) {
                $response['message'] = 'Registro no encontrado';
                $codigo = 200;

                return response()->json($response, status: $codigo);
            } else {
                $familiar->photo = Str::of($request->input('Photo'))->trim();
                $familiar->modified_by = Auth::user()->email;
                $familiar->save();
                DB::commit();
                $response['status'] = 'success';
                $response['message'] = $familiar->file_number;
                $codigo = 200;

                return response()->json($response, status: $codigo);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $response['debug'] = $e->getMessage();

        }
    }

    public function baja(Request $request, $id)
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
            'File_number' => 'required|max:8',
            'Inactive_date' => 'required|date',
            'Inactive_motive' => 'required',
            'Inactive_reference' => 'nullable|max:250',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['errors'] = $validator->errors()->toArray();
            $codigo = 200;

            return response()->json($response, status: $codigo);
        }

        DB::beginTransaction();
        try {
            $fecha_baja = $request->input('Inactive_date');
            $motivo_baja = Str::of($request->input('Inactive_motive'))->trim();
            $familiar = Beneficiary::find($id);
            $msg = '';

            if ($motivo_baja == 'Acta Administrativa del Titular') {
                $familiar->inactive_date = $fecha_baja;
                $familiar->inactive_motive = $motivo_baja;
                $familiar->affiliate_status = 'Baja';
                $familiar->inactive_reference = Str::of($request->input('Inactive_reference'))->trim();
                $familiar->modified_by = Auth::user()->email;
                $familiar->save();
                $msg = 'El registro '.$familiar->file_number.' fue dado de baja con éxito.';
            } elseif ($motivo_baja == 'Defunsión del Titular') {
                $familiar->inactive_date = $fecha_baja;
                $familiar->inactive_motive = $motivo_baja;
                $familiar->affiliate_status = 'Baja por Aplicar';
                $familiar->inactive_reference = Str::of($request->input('Inactive_reference'))->trim();
                $familiar->modified_by = Auth::user()->email;
                $familiar->save();
                $msg = 'El registro '.$familiar->file_number.' fue dado de baja con éxito.';
            } elseif ($motivo_baja == 'Pensión del Titular' || $motivo_baja == 'Renuncia del Titular') {
                $familiar->inactive_date = $fecha_baja;
                $familiar->inactive_motive = $motivo_baja;
                $familiar->affiliate_status = 'Baja por Aplicar';
                $familiar->inactive_reference = Str::of($request->input('Inactive_reference'))->trim();
                $familiar->modified_by = Auth::user()->email;
                $familiar->save();
                $msg = 'El registro '.$familiar->file_number.' fue dado de baja con éxito.';
            } elseif ($motivo_baja == 'Defunsión') {
                $familiar->inactive_date = $fecha_baja;
                $familiar->inactive_motive = $motivo_baja;
                $familiar->affiliate_status = 'Baja';
                $familiar->inactive_reference = Str::of($request->input('Inactive_reference'))->trim();
                $familiar->modified_by = Auth::user()->email;
                $familiar->save();
                $msg = 'El registro '.$familiar->file_number.' fue dado de baja con éxito.';
            } elseif ($motivo_baja == 'Solicitud del Titular') {
                $familiar->inactive_date = $fecha_baja;
                $familiar->inactive_motive = $motivo_baja;
                $familiar->affiliate_status = 'Baja';
                $familiar->inactive_reference = Str::of($request->input('Inactive_reference'))->trim();
                $familiar->modified_by = Auth::user()->email;
                $familiar->save();
                $msg = 'El registro '.$familiar->file_number.' fue dado de baja con éxito.';
            }

            DB::commit();
            $response['status'] = 'success';
            $response['message'] = $msg;
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } catch (Exception $e) {
            DB::rollBack();
            $response['debug'] = $e->getMessage();

            return response()->json($response, status: 500);
        }
    }

    public function update(Request $request, $id)
    {
        $todo = $request->all();
        $codigo = 0;
        $response['status'] = 'fail';
        $response['errors'] = '';
        $response['beneficiary'] = '';
        $response['debug'] = '';
        $rules = [
            //Valida si ya hay un registro en la tabla beneficiaries con el mismo numero de afiliacion con un estatus de activo
            // 'File_number' => [
            //     'Insured_id' =>'required',
            //     'required','max:8',
            //     Rule::unique('beneficiaries')->where(fn (Builder $query) => $query->where('affiliate_status','Activo')),
            // ],
            'Start_date' => 'required|date|date_format:Y-m-d',
            'Last_name_1' => 'required|min:2|max:20',
            'Last_name_2' => 'nullable|min:2|max:20',
            'Name' => 'required|min:2|max:30',
            'Birthday' => 'nullable|date|date_format:Y-m-d',
            'Sex' => 'required',
            'Rfc' => 'nullable|string|min:13|max:13',
            'Curp' => 'nullable|string|min:18|max: 18',
            'Disabled_person' => 'nullable |string',
            'Relationship' => 'nullable|string',
            'Address' => 'nullable|string|max:200',
            'Observations' => 'nullable|min:5|max:250',
            'Account_number' => 'nullable|digits:10|unique:insureds,account_number',
            'Clabe' => 'nullable', 'digits:18', 'unique:insureds,clabe',
            'Bank_id' => 'nullable',
            'Representative_name' => 'nullable|max:40',
            'Representative_rfc' => 'nullable | max:13|alpha_num:ascii',
            'Representative_curp' => 'nullable | max:18|alpha_num:ascii',
            'Representative_relationship' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            $response['errors'] = $validator->errors()->toArray();

            return response()->json($response, 200);
        }
        // Si la validación pasa, continua con el resto de tu lógica aquí
        DB::beginTransaction();
        try {

            $familiar = Beneficiary::find($id);
            $familiar->start_date = $request->input('Start_date');
            $familiar->last_name_1 = Str::of($request->input('Last_name_1'))->trim();
            $familiar->last_name_2 = Str::of($request->input('Last_name_2'))->trim();
            $familiar->name = Str::of($request->input('Name'))->trim();
            $familiar->birthday = $request->input('Birthday');
            $familiar->sex = $request->input('Sex');
            $rfc = Str::of($request->input('Rfc'))->trim();
            $familiar->rfc = Str::upper($rfc);
            $curp = Str::of($request->input('Curp'))->trim();
            $familiar->curp = Str::upper($curp);
            $familiar->disabled_person = Str::of($request->input('Disabled_person'))->trim();
            $familiar->relationship = Str::of($request->input('Relationship'))->trim();
            $familiar->address = Str::of($request->input('Address'))->trim();
            $familiar->observations = Str::of($request->input('Observations'))->trim();
            $familiar->clabe = Str::of($request->input('Clabe'))->trim();
            $familiar->bank_id = $request->input('Bank_id');
            $familiar->representative_name = Str::of($request->input('Representative_name'))->trim();
            $familiar->representative_rfc = Str::of($request->input('Representative_rfc'))->trim();
            $familiar->representative_curp = Str::of($request->input('Representative_curp'))->trim();
            $familiar->representative_relationship = Str::of($request->input('Representative_relationship'))->trim();
            $familiar->modified_by = Auth::user()->email;
            $familiar->save();
            DB::commit();
            $response['status'] = 'success';
            $response['beneficiary'] = $familiar->file_number;

            return response()->json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            $response['debug'] = $e->getMessage();

        }
    }
}
