@extends('layouts.pdf.headerandfooter')

@section('content')
    <style>
        .tituloDocumento {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0px 10px 0px;
            text-transform: uppercase;
        }

        .fechaDocumento {
            font-size: 12px;
            text-align: right;
            width: 100%;
            margin-bottom: 15px;
        }

        .info-card {
            width: 100%;
            border: 2px solid #009887;
            /* azul */
            border-radius: 7px;
            border-collapse: separate;
            padding: 3px;
            margin-bottom: 7px;
            font-size: 11px;
        }

        .info-header {
            background-color: #f0f0f0;
            padding: 7px;
            font-weight: bold;
            text-align: center;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
        }

        .leyendaFide {
            position: fixed;
            width: 100%;
            bottom: 100px;
            left: 0;
            right: 0;
            text-align: justify;
            font-size: 8px;
            margin: 0;
            line-height: 1;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .label {
            /* width: 25%; */
            font-weight: bold;
            padding: 2px 2px;
            vertical-align: top;
            font-size: 9px;
            text-align: right;
        }

        .value {
            /* width: 25%; */
            padding: 2px 2px;
            vertical-align: top;
            font-size: 9px;
        }

        .info-card td {
            border: none;
        }
    </style>
    <div class="tituloDocumento">ACUERDO DE MOVIMIENTO NOMINAL</div>
    <div class="fechaDocumento">
        <div class="section-title">Fecha de operación:</div>
        <div>{{ $procedure->createdAtFormatted ?? 'N/A' }}</div>
    </div>
    <!-- SECCION 1-->
    <table class="info-card">
        <tr>
            <td colspan="4" class="info-header">
                Información del Movimiento.
            </td>
        </tr>
        <tr>
            <td class="label">Tipo de movimiento nominal:</td>
            <td class="value">{{ $procedure->procedureType->name ?? 'N/D' }}</td>
            <td class="label">Tipo de relación laboral:</td>
            <td class="value">{{ $procedure->contractType->name ?? 'N/D' }}</td>
        </tr>
        <tr>
            <td class="label">Área de adscripción:</td>
            <td class="value">{{ $procedure->employee->area->name ?? 'N/D' }}</td>
            <td class="label">Fecha de aplicación:</td>
            <td class="value">{{ $procedure->effectiveDateFormatted ?? 'N/D' }}</td>
        </tr>
        <tr>
            <td class="label"></td>
            <td class="value"></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <table class="info-card">
        <tr>
            <td colspan="4" class="info-header">
                Información del trabajador.
            </td>
        </tr>
        <tr>
            <td class="label">Apellido paterno:</td>
            <td class="value">{{ $procedure->employee->last_name_1 ?? 'N/D' }}</td>
            <td class="label">Apellido materno:</td>
            <td class="value">{{ $procedure->employee->last_name_2 ?? 'N/D' }}</td>
        </tr>
        <tr>
            <td class="label">Nombre (s):</td>
            <td class="value">{{ $procedure->employee->name ?? 'N/D' }}</td>
            <td class="label">RFC:</td>
            <td class="value">{{ $procedure->employee->rfc ?? 'N/D' }}</td>
        </tr>
        <tr>
            <td class="label">CURP:</td>
            <td class="value">{{ $procedure->employee->curp ?? 'N/D' }}</td>
            <td class="label">Número de empleado:</td>
            <td class="value">{{ $procedure->employee->position->position_number ?? 'N/D' }}</td>
        </tr>
        <tr>
            <td class="label">Identificación Oficial (INE):</td>
            <td class="value">{{ $procedure->employee->ine ?? 'N/D' }}</td>
            <td class="label">Correo electrónico:</td>
            <td class="value">{{ $procedure->employee->email ?? 'N/D' }}</td>
        </tr>
        <tr>
            <td class="label">Estado civil:</td>
            <td class="value">{{ $procedure->employee->marital_status ?? 'N/D' }}</td>
            <td class="label">Nivel máximo de estudios:</td>
            <td class="value">{{ $procedure->employee->academic_level ?? 'N/D' }}</td>
        </tr>
        <tr>
            <td class="label">Nombre de contacto:</td>
            <td class="value">{{ $procedure->employee->emergency_name ?? 'N/D' }}</td>
            <td class="label">Teléfono de contacto:</td>
            <td class="value">{{ $procedure->employee->emergency_number ?? 'N/D' }}</td>
        </tr>
        <tr>
            <td class="label">Dirección de contacto:</td>
            <td class="value">{{ $procedure->employee->emergency_address ?? 'N/D' }}</td>
            <td class="label"></td>
            <td class="value"></td>
        </tr>
    </table>
    <table class="info-card">
        <tr>
            <td colspan="4" class="info-header">
                Información del Puesto.
            </td>
        </tr>
        <tr>
            <td class="info-header">Anterior</td>
        </tr>
        <tr>
            <td class="label">Categoría:</td>
            <td class="value">{{ $procedure->first_detail->old_category_name ?? 'N/D' }}</td>
            <td class="label">Sueldo bruto mensual:</td>
            <td class="value">{{ $procedure->first_detail->old_salary ?? 'N/D' }}</td>
        </tr>
        <tr>
            <td class="label">Área de adscripción:</td>
            <td class="value">{{ $procedure->first_detail->old_area_name ?? 'N/D' }}</td>
            <td class="label">Nombre del puesto:</td>
            <td class="value">{{ $procedure->first_detail->old_position_name ?? 'N/D' }}</td>
        </tr>
        <tr>
            <td class="info-header">Actual</td>
        </tr>
        <tr>
            <td class="label">Categoría:</td>
            <td class="value">{{ $procedure->position->category->name ?? 'N/D' }}</td>
            <td class="label">Sueldo bruto mensual:</td>
            <td class="value">{{ $procedure->employee->position->category->gross_salary ?? 'N/D' }}</td>
        </tr>
        <tr>
            <td class="label">Área de adscripción:</td>
            <td class="value">{{ $procedure->employee->area->name ?? 'N/D' }}</td>
            <td class="label">Nombre del puesto:</td>
            <td class="value">{{ $procedure->employee->position->position_name ?? 'N/D' }}</td>
        </tr>
    </table>
    <div class="leyendaFide">
        <strong> SE AUTORIZA HACER EL MOVIMIENTO NOMINAL DE ACUERDO A LAS FACULTADES QUE ME CONFIERE EL NUMERAL 113,FRACCION
            VII,
            DE LAS REGLAS DE OPERACION DEL FIDEICOMISO DE PRESTACIONES DE SEGURIDAD SOCIAL PARA LOS TRABAJADORES DEL SECTOR
            POLICIAL OPERATIVO AL SERVICIO DEL PODER EJECUTIVO DEL ESTADO DE CHIAPAS.</strong>
    </div>
    <div class="signatures">
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td>
                    <p>ELABORÓ</p>
                    <p>____________________________</p>
                    <p>{{ $jefeRH }}</p>
                    <p>Recursos Humanos</p>
                </td>
                <td>
                    <p>Vo. Bo.</p>
                    <p>____________________________</p>
                    <p>{{ $administrador }}</p>
                    <p>Administrador General</p>
                </td>
                <td>
                    <p>AUTORIZÓ</p>
                    <p>____________________________</p>
                    <p>{{ $coordinador }}</p>
                    <p>Coordinador General</p>
                </td>
            </tr>
        </table>
    </div>
@endsection
