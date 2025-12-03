<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        margin: 80px 40px 80px 40px;
    }

    /* ENCABEZADO */
    header {
        position: fixed;
        top: -60px;
        left: 0;
        right: 0;
        height: 70px;
        text-align: center;
        line-height: 1.2;
    }

    /* PIE DE PÁGINA */
    footer {
        position: fixed;
        bottom: -60px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 10px;
        line-height: 1.2;
        border-top: 1px solid #000;
        padding-top: 5px;
    }

    /* TABLA */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        border: 1px solid #000;
        padding: 4px 3px;
    }

    th {
        background: #ddd;
        font-weight: bold;
        font-size: 10px;
    }

    .titulo {
        font-size: 14px;
        font-weight: bold;
    }
</style>
</head>

<body>

<header>
    <div style="font-weight:bold; font-size:16px;">
        FIDEICOMISO DE PRESTACIONES DE SEGURIDAD SOCIAL<br>
        PARA LOS TRABAJADORES DEL SECTOR POLICIAL OPERATIVO<br>
        AL SERVICIO DEL PODER EJECUTIVO DEL ESTADO DE CHIAPAS
    </div>

    <div style="margin-top:5px; font-size:12px;">
        "2025, año de Rosario Castellanos Figueroa"
    </div>

    <div class="titulo" style="margin-top:10px;">
        REPORTE DE ALTAS DE TITULARES (TRABAJADORES)
    </div>

    <div style="margin-top:5px; font-size:12px;">
        DEL {{ $fechaInicio }} AL {{ $fechaFin }}
    </div>

    <div style="font-size:12px;">
        FECHA DE CREACIÓN: {{ $fechaCreacion }}
    </div>
</header>

<footer>
    9na Sur Poniente 462, Barr. Los Milagros. <br>
    C.P. 29066, Tuxtla Gutiérrez, Chiapas.<br>
    Tel. (961) 61 11623 y 61 11654
</footer>

<main>
    <table>
        <thead>
        <tr>
            <th>FOLIO</th>
            <th>NUM_EMPLEADO</th>
            <th>SUBDEPENDENCIA</th>
            <th>NOMBRE_COMPLETO</th>
            <th>RFC</th>
            <th>SEXO</th>
            <th>EDAD</th>
            <th>FECHA_ALTA_DEPENDENCIA</th>
            <th>FECHA_CAPTURA</th>
            <th>ESTATUS</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($registros as $r)
            <tr>
                <td>{{ $r->file_number }}</td>
                <td>{{ $r->employee_number }}</td>
                <td>{{ $r->subdependency->name }}</td>
                <td>{{ $r->last_name_1.' '.$r->last_name_2.' '.$r->name}}</td>
                <td>{{ $r->rfc }}</td>
                <td>{{ $r->sex }}</td>
                <td>{{ $r->file_number }}</td>
                <td>{{ $r->start_date }}</td>
                <td>{{ $r->created_at }}</td>
                <td>{{ $r->affiliationStatus->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>

</body>
</html>
