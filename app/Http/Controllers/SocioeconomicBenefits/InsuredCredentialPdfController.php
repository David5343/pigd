<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\CredentialInsured;
use App\Services\SocioeconomicBenefits\Code128Barcode;
use App\Services\SocioeconomicBenefits\InsuredCredentialMedia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class InsuredCredentialPdfController extends Controller
{
    public function show(int $insuredId, int $credentialId): Response
    {
        $credential = CredentialInsured::query()
            ->with(['insured.subdependency.dependency'])
            ->where('insured_id', $insuredId)
            ->findOrFail($credentialId);

        $titular = $credential->insured;

        abort_unless($titular, 404);
        abort_if(
            blank($titular->file_number)
                || blank($titular->rfc)
                || blank($titular->curp)
                || blank($titular->name)
                || (blank($titular->last_name_1) && blank($titular->last_name_2))
                || blank($titular->blood_type)
                || blank($titular->subdependency?->dependency?->name),
            422,
            'Faltan datos del titular necesarios para reconstruir la credencial.'
        );

        $media = app(InsuredCredentialMedia::class);
        $photoDataUri = $media->photoDataUri($titular);
        $signatureDataUri = $media->signatureDataUri($titular);
        $backgroundDataUri = $media->publicAssetDataUri('images/credenciales/Titular.jpg');
        $authoritySignatureDataUri = $media->publicAssetDataUri('images/firma_coordinador.png');

        abort_if(blank($photoDataUri), 422, 'No se encontró el archivo de fotografía del titular.');
        abort_if(blank($signatureDataUri), 422, 'No se encontró el archivo de firma del titular.');
        abort_if(blank($backgroundDataUri), 500, 'No se encontró el fondo de credencial para titulares.');
        abort_if(blank($authoritySignatureDataUri), 500, 'No se encontró la firma de la autoridad.');

        $fullName = collect([$titular->last_name_1, $titular->last_name_2, $titular->name])
            ->filter(fn ($part) => filled($part))
            ->implode(' ');
        $barcodeDataUri = app(Code128Barcode::class)->toDataUri($titular->file_number);

        return Pdf::setOption([
            'defaultFont' => 'DejaVu Sans',
            'dpi' => 150,
            'isRemoteEnabled' => false,
        ])->loadView('socioeconomic_benefits.credentials.insured', [
            'titular' => $titular,
            'credential' => $credential,
            'fullName' => $fullName,
            'dependencyName' => $titular->subdependency?->dependency?->name,
            'photoDataUri' => $photoDataUri,
            'signatureDataUri' => $signatureDataUri,
            'backgroundDataUri' => $backgroundDataUri,
            'authoritySignatureDataUri' => $authoritySignatureDataUri,
            'barcodeDataUri' => $barcodeDataUri,
        ])
            ->setPaper('letter', 'portrait')
            ->stream('credencial-'.$titular->file_number.'.pdf')
            ->header('Cache-Control', 'private, no-store');
    }
}
