<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: letter portrait;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            color: #111;
        }

        .page {
            position: relative;
            width: 612pt;
            height: 792pt;
            background: #fff;
        }

        .credential {
            position: absolute;
            left: 42pt;
            top: 22pt;
            width: 528pt;
            height: 159.4pt;
            overflow: hidden;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 528pt;
            height: 159.4pt;
        }

        .photo-frame {
            position: absolute;
            top: 21%;
            left: 0.8%;
            width: 14%;
            height: 59%;
            overflow: hidden;
            border: 1px solid #222;
            background: #fff;
        }

        .photo {
            width: 100%;
            height: 100%;
        }

        .holder-data {
            position: absolute;
            top: 25%;
            left: 15%;
            width: 38%;
            font-size: 7.5pt;
            font-weight: bold;
            line-height: 1.35;
        }

        .data-line {
            margin-bottom: 1.2pt;
        }

        .dependency {
            height: 20pt;
            overflow: hidden;
        }

        .issue-row {
            position: absolute;
            top: 64%;
            left: 15%;
            width: 38%;
            font-size: 7.2pt;
            font-weight: bold;
        }

        .issue-date {
            position: absolute;
            top: 63%;
            left: 15%;
            width: 22%;
            font-size: 7.2pt;
            font-weight: bold;
        }

        .valid-date {
            position: absolute;
            top: 72%;
            left: 15%;
            width: 24%;
            font-size: 7.2pt;
            font-weight: bold;
        }

        .blood-type {
            position: absolute;
            top: 72%;
            left: 40%;
            width: 13%;
            font-size: 7.2pt;
            font-weight: bold;
        }

        .full-name {
            position: absolute;
            top: 88%;
            left: 3%;
            width: 50%;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .barcode {
            position: absolute;
            top: 4%;
            left: 58%;
            width: 38%;
            height: 17%;
        }

        .barcode svg {
            display: block;
            width: 100%;
            height: 100%;
        }

        .signature-box {
            position: absolute;
            top: 25%;
            height: 42%;
            border: 1px solid #111;
            background: rgba(255, 255, 255, 0.7);
            text-align: center;
        }

        .holder-signature-box {
            left: 58%;
            width: 18%;
        }

        .authority-signature-box {
            left: 80%;
            width: 18%;
        }

        .signature-image {
            width: 100%;
            height: 100%;
        }

        .signature-label {
            position: absolute;
            top: 69%;
            font-size: 5.4pt;
            font-weight: bold;
            text-align: center;
            line-height: 1.25;
        }

        .holder-signature-label {
            left: 57%;
            width: 20%;
        }

        .authority-signature-label {
            left: 78%;
            width: 22%;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="credential">
            <img class="background" src="{{ $backgroundDataUri }}" alt="">

            <div class="photo-frame">
                <img class="photo" src="{{ $photoDataUri }}" alt="">
            </div>

            <div class="holder-data">
                <div class="data-line">FOLIO AFILIACIÓN: {{ $titular->file_number }}</div>
                <div class="data-line">RFC: {{ $titular->rfc }}</div>
                <div class="data-line">CURP: {{ $titular->curp }}</div>
                <div class="data-line dependency">DEPENDENCIA: {{ $dependencyName }}</div>
            </div>

            <div class="issue-date">
                EMISIÓN: {{ Carbon\Carbon::parse($credential->issued_at)->format('d/m/Y') }}
            </div>
            <div class="valid-date">
                VIGENCIA: {{ Carbon\Carbon::parse($credential->expires_at)->format('d/m/Y') }}
            </div>
            <div class="blood-type">
                TIPO DE SANGRE: {{ $titular->blood_type }}
            </div>

            <div class="full-name">{{ $fullName }}</div>

            <div class="barcode">
                <img src="{{ $barcodeDataUri }}" alt="" style="display:block; width:100%; height:100%;">
            </div>

            <div class="signature-box holder-signature-box">
                <img class="signature-image" src="{{ $signatureDataUri }}" alt="">
            </div>
            <div class="signature-box authority-signature-box">
                <img class="signature-image" src="{{ $authoritySignatureDataUri }}" alt="">
            </div>
            <div class="signature-label holder-signature-label">FIRMA DEL DERECHOHABIENTE</div>
            <div class="signature-label authority-signature-label">
                DR. DELMAR H. ROMÁN LLAVEN<br>
                COORDINADOR GENERAL
            </div>
        </div>
    </div>
</body>

</html>
