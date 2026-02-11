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
    top: -5px;     /* AJUSTA AQUÍ si quieres subir o bajar */
    left: 25px;
    width: 95px;    /* para imagen 417x387 */
    height: auto;
}

/* LOGO DERECHO */
.logo-right {
    position: fixed;
    top: -5px;      /* AJUSTA AQUÍ también */
    right: 25px;
    width: 125px;     /* para imagen 417x457 */
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

.resumen_titulo {
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 10px;
    font-size: 14px;

}
/* TABLA */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 17px;
}

th, td {
    border: 1px solid #000;
    padding: 4px 3px;
    word-wrap: break-word;
}

th {
    background: #ddd;
    text-align: center;
    font-size: 12px;
}

tr {
    page-break-inside: avoid;
}


</style>
</head>

<body>

<img src="{{ public_path('images/logo_chiapas.png') }}" class="logo-left">
<img src="{{ public_path('images/gob_chiapas.png') }}" class="logo-right">

<header>
    <div style="font-weight:bold; font-size:16px;">
        FIDEICOMISO DE PRESTACIONES DE SEGURIDAD SOCIAL<br>
        PARA LOS TRABAJADORES DEL SECTOR POLICIAL OPERATIVO<br>
        AL SERVICIO DEL PODER EJECUTIVO DEL ESTADO DE CHIAPAS
    </div>

    {{-- <div style="margin-top:5px; font-size:12px;">
        "2026, año de Jaime Sabines Gutiérrez."
    </div> --}}

    <div style="margin-top:10px; font-size:14px; font-weight:bold;">
        RESUMEN DE INDICADORES CLAVE.
    </div>

    <div style="margin-top:5px; font-size:12px;">
        {{-- DEL {{ $fechaInicio }} AL {{ $fechaFin }} --}}
        FECHA DE CORTE: {{ $fechaFin }}
    </div>

    {{-- <div style="font-size:12px;">
        FECHA DE CREACIÓN: {{ $fechaCreacion }}
    </div> --}}
</header>


<footer>
    9na Sur Poniente 462, Barr. Los Milagros.<br>
    C.P. 29066, Tuxtla Gutiérrez, Chiapas.<br>
    Tel. (961) 61 11623 y 61 11654
</footer>

<main>

    <div class="resumen_titulo">
        1.-TOTAL DE DERECHOHABIENTES: {{ $total }}
    </div>

<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th style="text-align:left;">TIPO DE DERECHOHABIENTE</th>
            <th style="text-align:right;">CANTIDAD</th>
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
    <div class="resumen_titulo">
        2.-ASEGURADOS POR DEPENDENCIA: {{ $total2 }}
    </div>
<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th style="text-align:left;">DEPENDENCIA</th>
            <th style="text-align:right;">CANTIDAD</th>
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
<br><br>
    <div class="resumen_titulo">
        3.-ASEGURADOS POR GÉNERO Y DEPENDENCIA: {{ $total2 }}
    </div>
<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th style="text-align:left;">GÉNERO</th>
            <th style="text-align:center;">SSP</th>
            <th style="text-align:center;">FGE</th>
            <th style="text-align:right;">CANTIDAD</th>
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
    <div class="resumen_titulo">
        4.-FAMILIARES POR GÉNERO Y DEPENDENCIA: {{ $totalBeneficiariesActiveByDate }}
    </div>
<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th style="text-align:left;">GÉNERO</th>
            <th style="text-align:center;">SSP</th>
            <th style="text-align:center;">FGE</th>
            <th style="text-align:right;">CANTIDAD</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>HOMBRES</td>
            <td style="text-align:center;">{{ $beneficiaryActivosByDateMaleSsp }}</td>
            <td style="text-align:center;">{{ $beneficiaryActivosByDateMaleFge }}</td>
            <td style="text-align:right;">{{ $totalBeneficiariesActiveByDateMale }}</td>
        </tr>
        <tr>
            <td>MUJERES</td>
            <td style="text-align:center;">{{ $beneficiaryActivosByDateFemaleSsp }}</td>
            <td style="text-align:center;">{{ $beneficiaryActivosByDateFemaleFge }}</td>
            <td style="text-align:right;">{{ $totalBeneficiariesActiveByDateFemale }}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align:left;">TOTAL</th>
            <th style="text-align:center;">{{ $totalBeneficiariesActiveByDateSsp }}</th>
            <th style="text-align:center;">{{ $totalBeneficiariesActiveByDateFge }}</th>
            <th style="text-align:right;">{{ $totalBeneficiariesActiveByDate }}</th>
        </tr>
    </tfoot>
</table>
<br><br>
<br><br>
<br><br>
<br><br>
    <div class="resumen_titulo">
        5.-PENSIONISTAS POR GÉNERO: {{ $pensionersTotalByDate }}
    </div>
<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th style="text-align:left;">GÉNERO</th>
            <th style="text-align:right;">CANTIDAD</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>HOMBRES</td>
            <td style="text-align:right;">{{ $pensionersByDateMale }}</td>
        </tr>
        <tr>
            <td>MUJERES</td>
            <td style="text-align:right;">{{ $pensionersByDateFemale }}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align:left;">TOTAL</th>
            <th style="text-align:right;">{{ $pensionersTotalByDate }}</th>
        </tr>
    </tfoot>
</table>
    <div class="resumen_titulo">
        6.-PENSIONISTAS POR TIPO DE PENSION: {{ $totalPensioners }}
    </div>
<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th style="text-align:left;">TIPO DE PENSIÓN</th>
            <th style="text-align:right;">CANTIDAD</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pensionersByType as $p)
            <tr>
                <td style="text-align:left;">{{ $p->pensionType->name }}</td>
                <td style="text-align:right;">{{ $p->total }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align:left;">TOTAL</th>
            <th style="text-align:right;">{{ $totalPensioners }}</th>
        </tr>
    </tfoot>
</table>
<br><br>
<br><br>
    <div class="resumen_titulo">
        7.-FAMILIARES DE PENSIONISTAS POR GÉNERO: {{ $pensionerBeneficiaryTotal }}
    </div>
<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th style="text-align:left;">GÉNERO</th>
            <th style="text-align:right;">CANTIDAD</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>HOMBRES</td>
            <td style="text-align:right;">{{ $pensionersBeneficiaryByDateMale }}</td>
        </tr>
        <tr>
            <td>MUJERES</td>
            <td style="text-align:right;">{{ $pensionersBeneficiaryByDateFemale }}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align:left;">TOTAL</th>
            <th style="text-align:right;">{{ $pensionerBeneficiaryTotal }}</th>
        </tr>
    </tfoot>
</table>
    <div class="resumen_titulo">
        8.-PREAFILIADOS POR GÉNERO Y DEPENDENCIA: {{ $insuredsPreafiliateTotalByDate }}
    </div>
<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th style="text-align:left;">GÉNERO</th>
            <th style="text-align:center;">SSP</th>
            <th style="text-align:center;">FGE</th>
            <th style="text-align:right;">CANTIDAD</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>HOMBRES</td>
            <td style="text-align:center;">{{ $insuredsPreafiliateByDateBySspMale }}</td>
            <td style="text-align:center;">{{ $insuredsPreafiliateByDateByFgeMale }}</td>
            <td style="text-align:right;">{{ $insuredsPreafiliateTotalByDateSsp }}</td>
        </tr>
        <tr>
            <td>MUJERES</td>
            <td style="text-align:center;">{{ $insuredsPreafiliateByDateBySspFemale }}</td>
            <td style="text-align:center;">{{ $insuredsPreafiliateByDateByFgeFemale }}</td>
            <td style="text-align:right;">{{ $insuredsPreafiliateTotalByDateFge }}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align:left;">TOTAL</th>
            <th style="text-align:center;">{{ $insuredsPreafiliateTotalByDateSsp }}</th>
            <th style="text-align:center;">{{ $insuredsPreafiliateTotalByDateFge }}</th>
            <th style="text-align:right;">{{ $insuredsPreafiliateTotalByDate }}</th>
        </tr>
    </tfoot>
</table>
</main>

</body>
</html>
