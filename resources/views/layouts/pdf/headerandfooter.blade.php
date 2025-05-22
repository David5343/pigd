<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        @page {
            margin: 3cm 2cm 2.5cm 2cm;
            /* top, right, bottom, left */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        header {
            position: fixed;
            top: -2.8cm;
            left: 0;
            right: 0;
            height: 2.8cm;
            text-align: center;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .center-text {
            text-align: center;
            line-height: 1;
        }

        footer {
            position: fixed;
            bottom: -2.2cm;
            left: 0;
            right: 0;
            height: 2.2cm;
            font-size: 10px;
        }

        footer .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        footer .page-number {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0.5cm;
            text-align: center;
            font-size: 10px;
        }

        .content {
            margin-top: 1cm;
        }

        img.logo {
            height: 60px;
        }

        .signatures {
            position: fixed;
            bottom: 8px;
            /* ajusta esta distancia según el alto de tu footer */
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            line-height: 1;
        }

        .signatures p {
            text-align: center;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <header>
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td style="text-align: left; vertical-align: top;">
                    <img src="{{ public_path('images/gob_chiapas.png') }}" style="width: 120px;">
                </td>
                <<td style="text-align: center; vertical-align: top; line-height: 1; margin: 0; padding: 0;">
                    FIDEICOMISO DE PRESTACIONES DE SEGURIDAD SOCIAL PARA LOS<br>
                    TRABAJADORES DEL SECTOR POLICIAL OPERATIVO AL SERVICIO DEL<br>
                    PODER EJECUTIVO DEL ESTADO DE CHIAPAS<br>
                    <strong>"2025, año de Rosario Castellanos Figueroa."</strong>
                    </td>
                    <td style="text-align: right; vertical-align: top;">
                        <img src="{{ public_path('images/gob_chiapas.png') }}" style="width: 120px;">
                    </td>
            </tr>
        </table>
    </header>


    <footer>
        <table width="100%" style="border-collapse: collapse; font-size: 9px;">
            <tr>
                <td style="text-align: left;">
                    <img src="{{ public_path('images/img_footer.jpeg') }}" style="width:320px; height: 30px;">
                </td>
                <td style="text-align: center;">
                    {{-- Aquí insertamos número de página de forma dinámica --}}
                    <script type="text/php">
                    if (isset($pdf)) {
                        $pdf->page_script(function($pageNumber, $pageCount, $pdf) {
                            $pdf->text($pdf->get_width() / 2 - 20, $pdf->get_height() - 30, "Página $pageNumber de $pageCount", null, 10);
                        });
                    }
                </script>
                </td>
                <td style="text-align: right;">
                    9a Sur Poniente #462, Barrio Los Milagros.<br>
                    C.P. 29066,Tuxtla Gutiérrez,Chiapas.<br>
                    Tel. (961) 611 16 23 y 611 16 54.
                </td>
            </tr>
        </table>
    </footer>
    <main>
        @yield('content')
    </main>
</body>

</html>
