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
        "2026, año de Jaime Sabines Gutiérrez."
    </div>

    <div style="margin-top:10px; font-size:14px; font-weight:bold;">
        RESUMEN DE INDICADORES CLAVE.
    </div>

    <div style="margin-top:5px; font-size:12px;">
        {{-- DEL {{ $fechaInicio }} AL {{ $fechaFin }} --}}
        AL DIA {{ $fechaFin }}
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
        1.-TOTAL DE DERECHOHABIENTES: {{ $total }}
    </div>

<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th style="text-align:left;">TIPO DE DERECHOHABIENTE</th>
            <th style="text-align:right;">SUBTOTAL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>ASEGURADOS</td>
            <td style="text-align:right;">{{ $insuredsActiveTotalByDate }}</td>
        </tr>
        <tr>
            <td>ASEGURADOS(PREAFILIADOS)</td>
            <td style="text-align:right;">{{ $insuredsPreafiliateTotalByDate }}</td>
        </tr>
        <tr>
            <td>FAMILIARES</td>
            <td style="text-align:right;">{{ $beneficiariesTotalByDate }}</td>
        </tr>
        <tr>
            <td>PENSIONISTAS</td>
            <td style="text-align:right;">{{ $pensionersTotalByDate }}</td>
        </tr>
        <tr>
            <td>FAM. DE PENSIONISTAS</td>
            <td style="text-align:right;">{{ $pensionersBTotalByDate }}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align:left;">TOTAL</th>
            <th style="text-align:right;">{{ $total }}</th>
        </tr>
    </tfoot>
</table>
    <div class="resumen">
        2.-ASEGURADOS POR DEPENDENCIA: {{ $total2 }}
    </div>
<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th style="text-align:left;">DEPENDENCIA</th>
            <th style="text-align:right;">SUBTOTAL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>SECRETARIA DE SEGURIDAD DEL PUEBLO</td>
            <td style="text-align:right;">{{ $insuredsActiveByDateSsp }}</td>
        </tr>
        <tr>
            <td>FISCALIA GENERAL DEL ESTADO</td>
            <td style="text-align:right;">{{ $insuredsActiveByDateFge }}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align:left;">TOTAL</th>
            <th style="text-align:right;">{{ $total2 }}</th>
        </tr>
    </tfoot>
</table>
    <div class="resumen">
        3.-ASEGURADOS POR GÉNERO Y DEPENDENCIA: {{ $total2 }}
    </div>
<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th style="text-align:left;">GÉNERO</th>
            <th style="text-align:center;">SSP</th>
            <th style="text-align:center;">FGE</th>
            <th style="text-align:right;">SUBTOTAL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>HOMBRES</td>
            <td style="text-align:center;">{{ $insuredsActiveByMaleSsp }}</td>
            <td style="text-align:center;">{{ $insuredsActiveByMaleFge }}</td>
            <td style="text-align:right;">{{ $totalInsuredsActiveByMale }}</td>
        </tr>
        <tr>
            <td>MUJERES</td>
            <td style="text-align:center;">{{ $insuredsActiveByFemaleSsp }}</td>
            <td style="text-align:center;">{{ $insuredsActiveByFemaleFge }}</td>
            <td style="text-align:right;">{{ $totalInsuredsActiveByFemale }}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align:left;">TOTAL</th>
            <th style="text-align:center;">{{$totalInsuredsActiveBySsp }}</th>
            <th style="text-align:center;">{{ $totalInsuredsActiveByFge}}</th>
            <th style="text-align:right;">{{ $totalInsuredsActive }}</th>
        </tr>
    </tfoot>
</table>
</main>

</body>
</html>
