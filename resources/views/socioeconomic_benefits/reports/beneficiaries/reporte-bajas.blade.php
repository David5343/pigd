<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 11px;
    margin: 170px 40px 80px 40px; /* espacio para header */
}

/* HEADER FIJO (SOLO PARA EL TEXTO, SIN IMÁGENES) */
header {
    position: fixed;
    top: -25px;
    left: 0;
    right: 0;
    height: 160px;
    text-align: center;
    border-bottom: 1px solid #7f8085;
    padding-bottom: 10px;
}

/* LOGO IZQUIERDO */
.logo-left {
    position: fixed;
    top: -10px;     /* AJUSTA AQUÍ si quieres subir o bajar */
    left: 25px;
    width: 85px;    /* para imagen 417x387 */
    height: auto;
}

/* LOGO DERECHO */
.logo-right {
    position: fixed;
    top: -10px;      /* AJUSTA AQUÍ también */
    right: 25px;
    width: 85px;     /* para imagen 417x457 */
    height: auto;
}

/* FOOTER */
footer {
    position: fixed;
    bottom: -60px;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 10px;
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
    word-wrap: break-word;
}

th {
    background: #ddd;
    text-align: center;
    font-size: 10px;
}

tr {
    page-break-inside: avoid;
}


</style>
</head>

<body>

<img src="{{ public_path('images/gob_chiapas.png') }}" class="logo-left">
<img src="{{ public_path('images/logo_fide.png') }}" class="logo-right">

<header>
    <div style="font-weight:bold; font-size:16px;">
        FIDEICOMISO DE PRESTACIONES DE SEGURIDAD SOCIAL<br>
        PARA LOS TRABAJADORES DEL SECTOR POLICIAL OPERATIVO<br>
        AL SERVICIO DEL PODER EJECUTIVO DEL ESTADO DE CHIAPAS
    </div>

    <div style="margin-top:5px; font-size:12px;">
        "2025, año de Rosario Castellanos Figueroa"
    </div>

    <div style="margin-top:10px; font-size:14px; font-weight:bold;">
        REPORTE DE BAJAS DE FAMILIARES
    </div>

    <div style="margin-top:5px; font-size:12px;">
        DEL {{ $fechaInicio }} AL {{ $fechaFin }}
    </div>

    <div style="font-size:12px;">
        FECHA DE CREACIÓN: {{ $fechaCreacion }}
    </div>
</header>


<footer>
    9na Sur Poniente 462, Barr. Los Milagros.<br>
    C.P. 29066, Tuxtla Gutiérrez, Chiapas.<br>
    Tel. (961) 61 11623 y 61 11654
</footer>

<main>

    <div class="resumen">
        TOTAL DE BAJAS: {{ $total }}
    </div>

    <table>
        <thead>
        <tr>
            <th>FOLIO</th>
            <th>NOMBRE_COMPLETO</th>
            <th>CURP</th>
            <th>SEXO</th>
            <th>PARENTESCO</th>
            <th>FECHA_BAJA</th>
            <th>ESTATUS</th>
            <th>FOLIO_TRABAJADOR</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($registros as $r)
            <tr>
                <td>{{ $r->file_number }}</td>
                <td>{{ $r->last_name_1.' '.$r->last_name_2.' '.$r->name }}</td>
                <td>{{ $r->curp }}</td>
                <td>{{ $r->sex }}</td>
                <td>{{ $r->relationship }}</td>
                <td>{{ $r->inactive_date }}</td>
                <td>{{ $r->affiliate_status }}</td>
                <td>{{ $r->insured->file_number }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</main>

</body>
</html>
