<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocioeconomicBenefits\Insured;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InsuredReportsController extends Controller
{
    public function altas()
    {
        $inicio = request('inicio') . ' 00:00:00';
        $fin = request('fin') . ' 23:59:59';

        $registros = Insured::with(['subdependency', 'affiliationStatus'])
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
            ->loadView('socioeconomic_benefits.reports.insureds.reporte-altas', $data)
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

        $registros = Insured::with(['subdependency', 'affiliationStatus'])
            ->whereBetween('inactive_date', [$inicio, $fin])
            ->where('affiliation_status_id',4)
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
            ->loadView('socioeconomic_benefits.reports.insureds.reporte-bajas', $data)
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

        return $pdf->download('reporte-bajas-titulares.pdf');
    }
    public function byAdscripcion()
    {
    // 🔥 AUMENTAR RECURSOS (AQUÍ)
    ini_set('memory_limit', '512M');
    set_time_limit(300);
        $inicio = Carbon::parse(request('inicio'))->format('Y-m-d');
        $fin = Carbon::parse(request('fin'))->format('Y-m-d');

    $registros = Insured::with([
        'subdependency:id,name',
        'affiliationStatus:id,name'
    ])
    ->select([
        'id',
        'file_number',
        'employee_number',
        'subdependency_id',
        'last_name_1',
        'last_name_2',
        'name',
        'rfc',
        'sex',
        'start_date',
        'created_at',
        'affiliation_status_id'
    ])
    ->whereIn('affiliation_status_id', [1,2])
    ->whereBetween('start_date', [$inicio, $fin])
    ->orderBy('subdependency_id')
    ->get()
    ->groupBy(function ($item) {
        return $item->subdependency ? $item->subdependency->name : 'Sin adscripción';
    })
    ->map(function ($group, $key) {
        return [
            'adscripcion' => $key,
            'total' => $group->count(),
            'registros' => $group->values()
        ];
    })->values();
        $data = [
            'registros' => $registros,
            'total' => $registros->sum('total'),
            'fechaInicio' => Carbon::parse(request('inicio'))->format('d/m/Y'),
            'fechaFin' => Carbon::parse(request('fin'))->format('d/m/Y'),
            'fechaCreacion' => now()->format('d/m/Y'),
        ];

        $pdf = Pdf::setOption([
            'defaultFont' => 'DejaVu Sans',
            'isPhpEnabled' => true,
            'margin-top' => 170,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 96,
        ])
            ->loadView('socioeconomic_benefits.reports.insureds.reporte-adscripcion', $data)
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

        return $pdf->download('reporte-asegurados-por-adscripcion.pdf');
    }
}
