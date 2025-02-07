<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use App\Models\SocioeconomicBenefits\Insured;
use App\Models\SocioeconomicBenefits\Retiree;
use App\Models\SocioeconomicBenefits\Ticket;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TicketApiController extends Controller
{
    public function index()
    {
        $response['Status'] = 'fail';
        $response['Message'] = 'No hay Datos que mostrar.';
        $response['Errors'] = null;
        $response['Ticket'] = null;
        $response['Tickets'] = [];
        $response['Insured'] = null;
        $response['Beneficiary'] = null;
        $response['Retiree'] = null;
        $response['Debug'] = null;

        $turnos = Ticket::with(['insured', 'beneficiary', 'retiree', 'retiree.insured', 'retiree.beneficiary'])
            ->whereDate('Ticket_date', Carbon::today())
            ->latest()
            ->get();
        if (! $turnos->isEmpty()) {
            $response['Status'] = 'success';
            $response['Message'] = 'Datos encontrados';
            $response['Tickets'] = $turnos;
        }

        return response()->json($response);
    }

    public function busqueda(Request $request)
    {
        $dato = trim($request->dato);
        $response['Status'] = 'fail';
        $response['Message'] = 'No hay Datos que mostrar.';
        $response['Errors'] = null;
        $response['Ticket'] = null;
        $response['Tickets'] = [];
        $response['Insured'] = null;
        $response['Beneficiary'] = null;
        $response['Retiree'] = null;
        $response['Debug'] = null;

        $turnos_insured = Ticket::with('insured')
            ->whereHas('insured', function ($query) use ($dato) {
                $query->where('file_number', $dato)
                    ->orWhere('rfc', $dato)
                    ->orWhere('curp', $dato)
                    ->orWhere('name', 'LIKE', "%{$dato}%")
                    ->orWhere('last_name_1', 'LIKE', "%{$dato}%")
                    ->orWhere('last_name_2', 'LIKE', "%{$dato}%");
            })->get();
        $turnos_beneficiary = Ticket::with('beneficiary')
            ->whereHas('beneficiary', function ($query) use ($dato) {
                $query->where('file_number', $dato)
                    ->orWhere('rfc', $dato)
                    ->orWhere('curp', $dato)
                    ->orWhere('name', 'LIKE', "%{$dato}%")
                    ->orWhere('last_name_1', 'LIKE', "%{$dato}%")
                    ->orWhere('last_name_2', 'LIKE', "%{$dato}%");
            })->get();
        $turnos_retiree = Ticket::with('retiree.insured')
            ->WhereHas('retiree', function ($query) use ($dato) {
                $query->where('file_number', $dato)
                    ->orwhere('noi_number', $dato);
            })
            ->orWhereHas('retiree.insured', function ($query) use ($dato) {
                $query->where('file_number', $dato)
                    ->orWhere('rfc', $dato)
                    ->orWhere('curp', $dato)
                    ->orWhere('name', 'LIKE', "%{$dato}%")
                    ->orWhere('last_name_1', 'LIKE', "%{$dato}%")
                    ->orWhere('last_name_2', 'LIKE', "%{$dato}%");
            })
            ->orWhereHas('retiree.beneficiary', function ($query) use ($dato) {
                $query->where('file_number', $dato)
                    ->orWhere('rfc', $dato)
                    ->orWhere('curp', $dato)
                    ->orWhere('name', 'LIKE', "%{$dato}%")
                    ->orWhere('last_name_1', 'LIKE', "%{$dato}%")
                    ->orWhere('last_name_2', 'LIKE', "%{$dato}%");
            })->get();
        if ($turnos_insured->isNotEmpty()) {
            $response['Status'] = 'success';
            $response['Message'] = 'Se encontraron los siguientes Datos.';
            $response['Tickets'] = $turnos_insured;
        } elseif ($turnos_beneficiary->isNotEmpty()) {
            $response['Status'] = 'success';
            $response['Message'] = 'Se encontraron los siguientes Datos.';
            $response['Tickets'] = $turnos_beneficiary;
        } elseif ($turnos_retiree->isNotEmpty()) {
            $response['Status'] = 'success';
            $response['Message'] = 'Se encontraron los siguientes Datos.';
            $response['Tickets'] = $turnos_retiree;
        }

        return response()->json($response, 200);
    }

    public function show($id)
    {
        $response['Status'] = 'fail';
        $response['Message'] = 'No hay Datos que mostrar.';
        $response['Errors'] = null;
        $response['Ticket'] = null;
        $response['Tickets'] = [];
        $response['Insured'] = null;
        $response['Beneficiary'] = null;
        $response['Retiree'] = null;
        $response['Debug'] = null;

        $turno = Ticket::with(['insured.subdependency', 'beneficiary.insured.subdependency', 'retiree', 'retiree.insured.subdependency', 'retiree.beneficiary'])
            ->find($id);
        if ($turno != null) {
            $response['Status'] = 'success';
            $response['Message'] = 'Se encontró el siguiente registro:';
            $response['Ticket'] = $turno;

            return response()->json($response, 200);
        } else {
            $response['Status'] = 'fail';
            $response['Message'] = 'La Solicitud no es de tipo :Reposición';

            return response()->json($response, 200);
        }
    }

    public function store(Request $request)
    {
        $response['Status'] = 'fail';
        $response['Message'] = 'No hay Datos que mostrar.';
        $response['Errors'] = null;
        $response['Ticket'] = null;
        $response['Tickets'] = [];
        $response['Insured'] = null;
        $response['Beneficiary'] = null;
        $response['Retiree'] = null;
        $response['Debug'] = null;

        $rules = [
            'Ticket_number' => [
                'required',
                'string',
                'max:3',
                'min:1',
                Rule::unique('tickets')->where(function ($query) {
                    $fechaActual = now()->toDateString();

                    return $query->where('ticket_date', $fechaActual);
                }),
            ],
            'Requester' => 'required | max:70 | min:4',
            'Procedure_type' => 'required',
            'Requester_movil' => 'required | max:14',
            'Insured_type' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            $response['Message'] = 'Se encontraron los siguientes errores:';
            $response['Errors'] = [$validator->errors()->toArray()];
            // $response['Debug'] = $request->all();

            return response()->json($response, 200);
        }
        DB::beginTransaction();
        try {
            $fechaActual = now()->toDateString();
            $turno = new Ticket();
            $turno->ticket_number = $request->input('Ticket_number');
            $turno->requester = $request->input('Requester');
            $turno->ticket_date = $fechaActual;
            $turno->procedure_type = $request->input('Procedure_type');
            $turno->requester_movil = $request->input('Requester_movil');
            $turno->insured_type = $request->input('Insured_type');
            if ($request->input('Insured_id') != null) {
                $turno->insured_id = $request->input('Insured_id');
            }
            if ($request->input('Beneficiary_id') != null) {
                $turno->beneficiary_id = $request->input('Beneficiary_id');
            }
            if ($request->input('Retiree_id') != null) {
                $turno->retiree_id = $request->input('Retiree_id');
            }
            $turno->ticket_status = 'EN PROCESO';
            $turno->status = 'active';
            $turno->modified_by = Auth::user()->email;
            $turno->save();
            DB::commit();
            $response['Status'] = 'success';
            $response['Message'] = 'El Turno '.$turno->ticket_number.' fue creado correctamente';

            return response()->json($response, 200);

        } catch (Exception $e) {
            DB::rollBack();
            $response['Debug'] = $e->getMessage();

        }
    }

    public function update(Request $request)
    {
        $response['Status'] = 'fail';
        $response['Message'] = 'No hay Datos que mostrar.';
        $response['Errors'] = null;
        $response['Ticket'] = null;
        $response['Tickets'] = [];
        $response['Insured'] = null;
        $response['Beneficiary'] = null;
        $response['Retiree'] = null;
        $response['Debug'] = null;

        $id = $request->input('Id');
        $turno = Ticket::find($id);
        if ($turno->ticket_status == 'FINALIZADO') {
            $response['Status'] = 'fail';
            $response['Message'] = 'Este turno ya fue finalizado con anterioridad.';

            return response()->json($response, 200);
        } else {
            $turno->ticket_status = 'FINALIZADO';
            $turno->status = 'active';
            $turno->modified_by = Auth::user()->email;
            $turno->save();
            $response['Status'] = 'success';
            $response['Message'] = 'El turno fue finalizado con éxito.';

            return response()->json($response, 200);
        }

    }

    public function cancel(Request $request)
    {
        $response['Status'] = 'fail';
        $response['Message'] = 'No hay Datos que mostrar.';
        $response['Errors'] = null;
        $response['Ticket'] = null;
        $response['Tickets'] = [];
        $response['Insured'] = null;
        $response['Beneficiary'] = null;
        $response['Retiree'] = null;
        $response['Debug'] = null;

        $id = $request->input('Id');
        $turno = Ticket::find($id);
        if ($turno->ticket_status == 'CANCELADO') {
            $response['Status'] = 'fail';
            $response['Message'] = 'Este turno ya fue Cancelado con anterioridad.';

            return response()->json($response, 200);
        } else {
            $turno->ticket_status = 'CANCELADO';
            $turno->status = 'active';
            $turno->modified_by = Auth::user()->email;
            $turno->save();
            $response['Status'] = 'success';
            $response['Message'] = 'El turno fue Cancelado con éxito.';

            return response()->json($response, 200);
        }

    }

    public function search(Request $request)
    {
        $dato = $request->dato;
        $response['Status'] = 'fail';
        $response['Message'] = 'No hay Datos que mostrar.';
        $response['Errors'] = null;
        $response['Ticket'] = null;
        $response['Tickets'] = [];
        $response['Insured'] = null;
        $response['Beneficiary'] = null;
        $response['Retiree'] = null;
        $response['Debug'] = null;
        $titular = Insured::where('affiliate_status', 'Activo')
            ->where(function ($query) use ($dato) {
                $query->where('file_number', $dato)
                    ->orWhere('rfc', $dato)
                    ->orWhere('curp', $dato);
            })
            ->first();
        $familiar = Beneficiary::where('affiliate_status', 'Activo')
            ->where(function ($query) use ($dato) {
                $query->where('file_number', $dato)
                    ->orwhere('rfc', $dato)
                    ->orwhere('curp', $dato);
            })
            ->first();
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
            ->orWhereHas('beneficiary', function ($query) use ($dato) {
                $query->where('file_number', $dato);
            })
            ->orWhereHas('beneficiary', function ($query) use ($dato) {
                $query->where('rfc', $dato);
            })
            ->orWhereHas('beneficiary', function ($query) use ($dato) {
                $query->where('curp', $dato);
            })
            ->first();
        if ($titular != null) {
            $response['Status'] = 'success';
            $response['Insured'] = $titular;
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } elseif ($familiar != null) {
            $response['Status'] = 'success';
            $response['Beneficiary'] = $familiar;
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } elseif ($retiree != null) {
            $response['Status'] = 'success';
            $response['Retiree'] = $retiree;
            $codigo = 200;

            return response()->json($response, status: $codigo);
        } else {
            $response['Message'] = 'Registro no encontrado.';
            $codigo = 200;

            return response()->json($response, status: $codigo);
        }
    }

    public function searchByDate(Request $request)
    {
        $response['Status'] = 'fail';
        $response['Message'] = 'No hay Datos que mostrar.';
        $response['Errors'] = null;
        $response['Ticket'] = null;
        $response['Tickets'] = [];
        $response['Insured'] = null;
        $response['Beneficiary'] = null;
        $response['Retiree'] = null;
        $response['Debug'] = null;

        $fecha1 = $request->query('fecha1');
        $fecha2 = $request->query('fecha2');

        if (! $fecha1 || ! $fecha2) {
            $response['Message'] = 'Faltan Parámetros';

            return response()->json($response, 400);
        }

        $turnos = Ticket::with(['insured', 'beneficiary', 'retiree', 'retiree.insured', 'retiree.beneficiary'])
            ->whereBetween('ticket_date', [$fecha1, $fecha2])
            ->get();
        if ($turnos->isNotEmpty()) {
            $response['Status'] = 'success';
            $response['Message'] = 'Datos encontrados';
            $response['Tickets'] = $turnos;
        }
        $response['Debug'] = $fecha1;
        return response()->json($response);
    }
}
