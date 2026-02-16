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
use Illuminate\Support\Facades\DB;

class KpisOverviewReportsController extends Controller
{
    public function getInsuredsTotal()
    {
        // $inicio = request('inicio') . ' 00:00:00';
        // $fin = request('fin') . ' 23:59:59';
        $inicio = Carbon::parse(request('inicio').' 00:00:00', 'America/Mexico_City')->setTimezone('UTC');
        $fin = Carbon::parse(request('fin').' 23:59:59', 'America/Mexico_City')->setTimezone('UTC');
        $creationDate = now()->format('d-m-Y');
        //consultas de indicador 1
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
        //consultas de indicador 2
        $insuredsActiveByDateSsp = Insured::with('subdependency.dependency')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->whereBetween('created_at', [$inicio, $fin])
            ->count();
        $insuredsActiveByDateFge = Insured::with('subdependency.dependency')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->whereBetween('created_at', [$inicio, $fin])
            ->count();
        $total2 = $insuredsActiveByDateSsp + $insuredsActiveByDateFge;
        //consultas de indicador 3
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
        //consultas de indicador 4
        $beneficiaryActivosByDateMaleSsp = Beneficiary::with('insured.subdependency.dependency')
            ->where('sex', 'Hombre')
            ->whereIn('affiliate_status', ['Activo','Baja por aplicar'])
            ->whereHas('insured.subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->count();
        $beneficiaryActivosByDateFemaleSsp = Beneficiary::with('insured.subdependency.dependency')
            ->where('sex', 'Mujer')
            ->whereIn('affiliate_status', ['Activo','Baja por aplicar'])
            ->whereHas('insured.subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->count();
        $beneficiaryActivosByDateMaleFge = Beneficiary::with('insured.subdependency.dependency')
            ->where('sex', 'Hombre')
            ->whereIn('affiliate_status', ['Activo','Baja por aplicar'])
            ->whereHas('insured.subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->count();
        $beneficiaryActivosByDateFemaleFge = Beneficiary::with('insured.subdependency.dependency')
            ->where('sex', 'Mujer')
            ->whereIn('affiliate_status', ['Activo','Baja por aplicar'])
            ->whereHas('insured.subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->count();
            $totalBeneficiariesActiveByDateMale= $beneficiaryActivosByDateMaleSsp + $beneficiaryActivosByDateMaleFge;
            $totalBeneficiariesActiveByDateFemale= $beneficiaryActivosByDateFemaleSsp + $beneficiaryActivosByDateFemaleFge;
            $totalBeneficiariesActiveByDateSsp = $beneficiaryActivosByDateMaleSsp + $beneficiaryActivosByDateFemaleSsp;
            $totalBeneficiariesActiveByDateFge = $beneficiaryActivosByDateMaleFge + $beneficiaryActivosByDateFemaleFge;
            $totalBeneficiariesActiveByDate = $totalBeneficiariesActiveByDateSsp + $totalBeneficiariesActiveByDateFge;

        //Consultas de indicador 5
        $pensionersByDateMale = Pensioner::where('sex', 'Hombre')
            ->where('status','Activo')
            ->whereBetween('created_at',[$inicio, $fin])
            ->count();
        $pensionersByDateFemale = Pensioner::where('sex', 'Mujer')
            ->where('status', 'Activo')
            ->whereBetween('created_at',[$inicio, $fin])
            ->count();
        $pensionersTotalByDateMaleFemale = $pensionersByDateMale + $pensionersByDateFemale;
        //Consulta de indicadores 6
        $pensionersByType = Pensioner::where('status', 'Activo')
            ->select('pension_types_id', DB::raw('COUNT(*) as total'))
            ->groupBy('pension_types_id')
            ->with('pensionType:id,name')
            ->get();
        $totalPensioners = $pensionersByType->sum('total');
        //Consulta de indicadores 7
        $pensionersBeneficiaryByDateMale = PensionerBeneficiary::where('sex', 'Hombre')
            ->where('status','Activo')
            ->whereBetween('created_at',[$inicio, $fin])
            ->count();
        $pensionersBeneficiaryByDateFemale = PensionerBeneficiary::where('sex', 'Mujer')
            ->where('status','Activo')
            ->whereBetween('created_at',[$inicio, $fin])
            ->count();
        $pensionerBeneficiaryTotal= $pensionersBeneficiaryByDateMale+$pensionersBeneficiaryByDateFemale;
        //Consulta de indicadores 8
        //SSP
        $insuredsPreafiliateByDateBySspMale = Insured::where('sex', 'Hombre')
            ->where('affiliation_status_id', 1)
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })->count();
        $insuredsPreafiliateByDateBySspFemale = Insured::where('sex', 'Mujer')
            ->where('affiliation_status_id', 1)
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })->count();
        $insuredsPreafiliateTotalByDateSsp = $insuredsPreafiliateByDateBySspMale + $insuredsPreafiliateByDateBySspFemale;
        //FGE
        $insuredsPreafiliateByDateByFgeMale = Insured::where('sex', 'Hombre')
            ->where('affiliation_status_id', 1)
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalía General del Estado');
            })->count();
        $insuredsPreafiliateByDateByFgeFemale = Insured::where('sex', 'Mujer')
            ->where('affiliation_status_id', 1)
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalía General del Estado');
            })->count();
        $insuredsPreafiliateTotalByDateFge = $insuredsPreafiliateByDateByFgeMale + $insuredsPreafiliateByDateByFgeFemale;
        $insuredsPreafiliateTotalByDateMale = $insuredsPreafiliateByDateBySspMale + $insuredsPreafiliateByDateByFgeMale;
        $insuredsPreafiliateTotalByDateFemale = $insuredsPreafiliateByDateBySspFemale + $insuredsPreafiliateByDateByFgeFemale;
        $insuredsPreafiliateTotalByDateSspFge = $insuredsPreafiliateTotalByDateSsp + $insuredsPreafiliateTotalByDateFge;
        // Preparar datos para la vista
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
            'beneficiaryActivosByDateMaleSsp' => number_format($beneficiaryActivosByDateMaleSsp, 0, '.', ','),
            'beneficiaryActivosByDateMaleFge' => number_format($beneficiaryActivosByDateMaleFge, 0, '.', ','),
            'beneficiaryActivosByDateFemaleSsp' => number_format($beneficiaryActivosByDateFemaleSsp, 0, '.', ','),
            'beneficiaryActivosByDateFemaleFge' => number_format($beneficiaryActivosByDateFemaleFge, 0, '.', ','),
            'totalBeneficiariesActiveByDateMale' => number_format($totalBeneficiariesActiveByDateMale, 0, '.', ','),
            'totalBeneficiariesActiveByDateFemale' => number_format($totalBeneficiariesActiveByDateFemale, 0, '.', ','),
            'totalBeneficiariesActiveByDateSsp' => number_format($totalBeneficiariesActiveByDateSsp, 0, '.', ','),
            'totalBeneficiariesActiveByDateFge' => number_format($totalBeneficiariesActiveByDateFge, 0, '.', ','),
            'totalBeneficiariesActiveByDate' => number_format($totalBeneficiariesActiveByDate, 0, '.', ','),
            'pensionersByDateMale' => number_format($pensionersByDateMale, 0, '.', ','),
            'pensionersByDateFemale' => number_format($pensionersByDateFemale, 0, '.', ','),
            'pensionersTotalByDateMaleFemale' => number_format($pensionersTotalByDateMaleFemale, 0, '.', ','),
            'pensionersByType' => $pensionersByType,
            'totalPensioners' => number_format($totalPensioners, 0, '.', ','),
            'pensionersBeneficiaryByDateMale'=>number_format($pensionersBeneficiaryByDateMale, 0, '.', ','),
            'pensionersBeneficiaryByDateFemale'=>number_format($pensionersBeneficiaryByDateFemale, 0, '.', ','),
            'pensionerBeneficiaryTotal'=> number_format($pensionerBeneficiaryTotal, 0, '.', ','),
            'insuredsPreafiliateByDateBySspMale'=>number_format($insuredsPreafiliateByDateBySspMale, 0, '.', ','),
            'insuredsPreafiliateByDateBySspFemale'=>number_format($insuredsPreafiliateByDateBySspFemale, 0, '.', ','),
            'insuredsPreafiliateByDateByFgeMale'=>number_format($insuredsPreafiliateByDateByFgeMale, 0, '.', ','),
            'insuredsPreafiliateByDateByFgeFemale'=>number_format($insuredsPreafiliateByDateByFgeFemale, 0, '.', ','),
            'insuredsPreafiliateTotalByDateMale'=>number_format($insuredsPreafiliateTotalByDateMale, 0, '.', ','),
            'insuredsPreafiliateTotalByDateFemale'=>number_format($insuredsPreafiliateTotalByDateFemale, 0, '.', ','),
            'insuredsPreafiliateTotalByDateSsp'=>number_format($insuredsPreafiliateTotalByDateSsp, 0, '.', ','),
            'insuredsPreafiliateTotalByDateFge'=>number_format($insuredsPreafiliateTotalByDateFge, 0, '.', ','),
            'insuredsPreafiliateTotalByDateSspFge'=>number_format($insuredsPreafiliateTotalByDateSspFge, 0, '.', ','),
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

        return $pdf->download('indicadores-al-' . $creationDate . '.pdf');
    }
}
