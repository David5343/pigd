<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use App\Models\SocioeconomicBenefits\Insured;
use App\Models\SocioeconomicBenefits\Pensioner;
use App\Models\SocioeconomicBenefits\PensionerBeneficiary;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class KpisOverviewReportsController extends Controller
{
    public function getInsuredsTotal()
    {
        $inicio = request('inicio') . ' 00:00:00';
        $fin = request('fin') . ' 23:59:59';
        $creationDate = now()->format('d-m-Y');
        $insuredsActiveTotalByDate = Insured::whereBetween('created_at', [$inicio, $fin])
            ->whereIn('affiliation_status_id', [2,5])
            ->count();
        $insuredsPreafiliateTotalByDate = Insured::whereBetween('created_at', [$inicio, $fin])
            ->where('affiliation_status_id', '1')
            ->count();
        $beneficiariesTotalByDate = Beneficiary::whereBetween('created_at',[$inicio, $fin])
            ->whereIn('affiliate_status',['Activo','Baja por aplicar'])
            ->count();
        $pensionersTotalByDate = Pensioner::whereBetween('created_at', [$inicio, $fin])
            ->where('status','Activo')
            ->count();
        $pensionersBTotalByDate = PensionerBeneficiary::whereBetween('created_at', [$inicio, $fin])
            ->where('affiliate_status','Activo')
            ->count();
        $totalGeneral = $insuredsActiveTotalByDate +  $insuredsPreafiliateTotalByDate +$beneficiariesTotalByDate + $pensionersTotalByDate + $pensionersBTotalByDate;

        $insuredsActiveByDateSsp = Insured::with('subdependency.dependency')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->count();
        $insuredsActiveByDateFge = Insured::with('subdependency.dependency')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->count();
        $total2 = $insuredsActiveByDateSsp + $insuredsActiveByDateFge;
        $insuredsActiveByMaleSsp = Insured::where('sex', 'Hombre')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })->count();
        $insuredsActiveByMaleFge = Insured::where('sex', 'Hombre')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })->count();
        $totalInsuredsActiveByMale = $insuredsActiveByMaleSsp + $insuredsActiveByMaleFge;
        $insuredsActiveByFemaleSsp = Insured::where('sex', 'Mujer')
            ->whereIn('affiliation_status_id', [1, 2, 5])
                        ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })->count();
        $insuredsActiveByFemaleFge = Insured::where('sex', 'Mujer')
            ->whereIn('affiliation_status_id', [1, 2, 5])
                        ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })->count();
        $totalInsuredsActiveByFemale = $insuredsActiveByFemaleSsp + $insuredsActiveByFemaleFge;
        $totalInsuredsActiveBySsp = $insuredsActiveByMaleSsp + $insuredsActiveByFemaleSsp;
        $totalInsuredsActiveByFge = $insuredsActiveByMaleFge + $insuredsActiveByFemaleFge;
        $totalInsuredsActive = $totalInsuredsActiveBySsp + $totalInsuredsActiveByFge;
        $data = [
            'insuredsActiveTotalByDate' => number_format($insuredsActiveTotalByDate, 0, '.', ','),
            'insuredsPreafiliateTotalByDate' => number_format($insuredsPreafiliateTotalByDate, 0, '.', ','),
            'beneficiariesTotalByDate' => number_format($beneficiariesTotalByDate, 0, '.', ','),
            'pensionersTotalByDate' => number_format($pensionersTotalByDate, 0, '.', ','),
            'pensionersBTotalByDate' => number_format($pensionersBTotalByDate, 0, '.', ','),
            'total' => number_format($totalGeneral, 0, '.', ','),
            'insuredsActiveByDateSsp' => number_format($insuredsActiveByDateSsp, 0, '.', ','),
            'insuredsActiveByDateFge' => number_format($insuredsActiveByDateFge, 0, '.', ','),
            'total2' => number_format($total2, 0, '.', ','),
            'insuredsActiveByMaleSsp' => number_format($insuredsActiveByMaleSsp, 0, '.', ','),
            'insuredsActiveByMaleFge' => number_format($insuredsActiveByMaleFge, 0, '.', ','),
            'totalInsuredsActiveByMale' => number_format($totalInsuredsActiveByMale, 0, '.', ','),
            'insuredsActiveByFemaleSsp' => number_format($insuredsActiveByFemaleSsp, 0, '.', ','),
            'insuredsActiveByFemaleFge' => number_format($insuredsActiveByFemaleFge, 0, '.', ','),
            'totalInsuredsActiveByFemale' => number_format($totalInsuredsActiveByFemale, 0, '.', ','),
            'totalInsuredsActiveBySsp' => number_format($totalInsuredsActiveBySsp, 0, '.', ','),
            'totalInsuredsActiveByFge' => number_format($totalInsuredsActiveByFge, 0, '.', ','),
            'totalInsuredsActive' => number_format($totalInsuredsActive, 0, '.', ','),
            'fechaInicio' => Carbon::parse(request('inicio'))->format('d/m/Y'),
            'fechaFin' => Carbon::parse(request('fin'))->format('d/m/Y'),
            'fechaCreacion' => now()->format('d/m/Y'),
        ];

        $pdf = Pdf::setOption([
            'defaultFont' => 'DejaVu Sans',
            'isPhpEnabled' => true,
            'margin-top' => 170,
        ])
            ->loadView('socioeconomic_benefits.reports.kpis-overview.kpis-overview', $data)
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

        return $pdf->download('reporte-al-' . $creationDate . '.pdf');
    }
}
