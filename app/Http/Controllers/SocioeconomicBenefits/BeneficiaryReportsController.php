<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class BeneficiaryReportsController extends Controller
{
    public function altas()
    {
        $inicio = request('inicio') . ' 00:00:00';
        $fin = request('fin') . ' 23:59:59';

        $registros = Beneficiary::with('insured')
            ->whereBetween('created_at', [$inicio, $fin])
            ->get();

        $data = [
            'registros' => $registros,
            'total' => $registros->count(),
            'fechaInicio' => Carbon::parse(request('inicio'))->format('d/m/Y'),
            'fechaFin' => Carbon::parse(request('fin'))->format('d/m/Y'),
            'fechaCreacion' => now()->format('d/m/Y'),
        ];

        $pdf = Pdf::setOption([
            'defaultFont' => 'DejaVu Sans',
            'isPhpEnabled' => true,
            'margin-top' => 170,
        ])
            ->loadView('socioeconomic_benefits.reports.beneficiaries.reporte-altas', $data)
            ->setPaper('letter', 'landscape');

        // footer
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->get_canvas();
        $font = $dompdf->getFontMetrics()->get_font('DejaVu Sans', 'normal');

        $canvas->page_text(
            $canvas->get_width() / 2,
            $canvas->get_height() - 35,
            'Página {PAGE_NUM} de {PAGE_COUNT}',
            $font,
            10,
            [0, 0, 0]
        );

        return $pdf->download('reporte-altas-titulares.pdf');
    }
    public function bajas()
    {
        $inicio = request('inicio') . ' 00:00:00';
        $fin = request('fin') . ' 23:59:59';

        $registros = Beneficiary::with('insured')
            ->whereBetween('inactive_date', [$inicio, $fin])
            ->where('affiliate_status','Baja')
            ->get();

        $data = [
            'registros' => $registros,
            'total' => $registros->count(),
            'fechaInicio' => Carbon::parse(request('inicio'))->format('d/m/Y'),
            'fechaFin' => Carbon::parse(request('fin'))->format('d/m/Y'),
            'fechaCreacion' => now()->format('d/m/Y'),
        ];

        $pdf = Pdf::setOption([
            'defaultFont' => 'DejaVu Sans',
            'isPhpEnabled' => true,
            'margin-top' => 170,
        ])
            ->loadView('socioeconomic_benefits.reports.beneficiaries.reporte-bajas', $data)
            ->setPaper('letter', 'landscape');

        // footer
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->get_canvas();
        $font = $dompdf->getFontMetrics()->get_font('DejaVu Sans', 'normal');

        $canvas->page_text(
            $canvas->get_width() / 2,
            $canvas->get_height() - 35,
            'Página {PAGE_NUM} de {PAGE_COUNT}',
            $font,
            10,
            [0, 0, 0]
        );

        return $pdf->download('reporte-bajas-familiares.pdf');
    }
}
