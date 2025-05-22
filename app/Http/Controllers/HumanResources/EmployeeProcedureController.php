<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Models\HumanResources\Employee;
use App\Models\HumanResources\EmployeeProcedure;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeeProcedureController extends Controller
{
    public function index()
    {
        return view('human_resources.employee-procedure.index');

    }
    public function create()
    {
        return view('human_resources.employee-procedure.create');

    }
    public function pdf(string $id)
    {
        $procedure = $procedure = EmployeeProcedure::with(['employee','procedureType','details'])->find($id);
        $valor = $procedure->employee->position->category->gross_salary;
        $procedure->employee->position->category->gross_salary = '$' . number_format($valor, 2, '.', ',');
        // Solo si tiene detalles, asignamos el primero
        $procedure->first_detail = $procedure->details->first();
        $record1 =  Employee::with(['position','degree'])
                                ->where(function ($query){
                                    $query->whereHas('position',function ($q){
                                        $q->where('position_name','Coordinador General');
                                    });
                                })->first();
        $coordinador = $record1 ? $record1->degree->abbreviation.' '.$record1->name . ' ' . $record1->last_name_1 . ' ' . $record1->last_name_2
                            : 'N/D';
        $record2 =  Employee::with('position')
                                ->where(function ($query){
                                    $query->whereHas('position',function ($q){
                                        $q->where('position_name','Administrador General');
                                    });
                                })->first();
        $administrador = $record2 ? $record2->degree->abbreviation.' '.$record2->name. ' ' . $record2->last_name_1 . ' ' . $record2->last_name_2
                        : 'N/D';
        $record3 =  Employee::with('position')
                                ->where(function ($query){
                                    $query->whereHas('position',function ($q){
                                        $q->where('position_name','Jefatura de recursos humanos');
                                    });
                                })->first();
        $jefeRH = $record3 ? $record3->degree->abbreviation.' '.$record3->name.' '.$record3->last_name_1 . ' ' . $record3->last_name_2
                        : 'N/D';  
        $pdf = Pdf::loadView('human_resources.employee-procedure.pdf', ['procedure' => $procedure,
        'coordinador' => $coordinador,
        'administrador' => $administrador,
        'jefeRH' =>$jefeRH
    ])->setPaper('letter');
        return $pdf->stream('employee_procedure.pdf');

    }
}
