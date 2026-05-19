<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use App\Models\SocioeconomicBenefits\CredentialBeneficiary;
use App\Models\SocioeconomicBenefits\CredentialInsured;
use App\Models\SocioeconomicBenefits\CredentialPensioner;
use App\Models\SocioeconomicBenefits\CredentialPensionerBeneficiary;
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
        $inicio = Carbon::parse(request('inicio'))->format('Y-m-d');
        $fin = Carbon::parse(request('fin'))->format('Y-m-d');
        $creationDate = now()->format('d-m-Y');
        //consultas de indicador 1
        $insuredsActiveTotalByDate = Insured::whereBetween('start_date', [$inicio, $fin])
            ->whereIn('affiliation_status_id', [2,5])
            ->count();
        $insuredsPreafiliateTotalByDate = Insured::whereBetween('start_date', [$inicio, $fin])
            ->where('affiliation_status_id', '1')
            ->count();
        $beneficiariesTotalByDate = Beneficiary::whereBetween('start_date',[$inicio, $fin])
            ->whereIn('affiliate_status',['Activo','Baja por aplicar'])
            ->count();
        $pensionersTotalByDate = Pensioner::whereBetween('start_date', [$inicio, $fin])
            ->where('status','Activo')
            ->count();
        $pensionersBTotalByDate = PensionerBeneficiary::whereBetween('start_date', [$inicio, $fin])
            ->where('affiliate_status','Activo')
            ->count();
        $totalGeneral = $insuredsActiveTotalByDate +  $insuredsPreafiliateTotalByDate +$beneficiariesTotalByDate + $pensionersTotalByDate + $pensionersBTotalByDate;
        //consultas de indicador 2
        $insuredsActiveByDateSsp = Insured::with('subdependency.dependency')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $insuredsActiveByDateFge = Insured::with('subdependency.dependency')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $total2 = $insuredsActiveByDateSsp + $insuredsActiveByDateFge;
        //consultas de indicador 3
        $insuredsActiveByMaleSsp = Insured::where('sex', 'Hombre')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $insuredsActiveByMaleFge = Insured::where('sex', 'Hombre')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $totalInsuredsActiveByMale = $insuredsActiveByMaleSsp + $insuredsActiveByMaleFge;
        $insuredsActiveByFemaleSsp = Insured::where('sex', 'Mujer')
            ->whereIn('affiliation_status_id', [1, 2, 5])
                        ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $insuredsActiveByFemaleFge = Insured::where('sex', 'Mujer')
            ->whereIn('affiliation_status_id', [1, 2, 5])
                        ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
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
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $beneficiaryActivosByDateFemaleSsp = Beneficiary::with('insured.subdependency.dependency')
            ->where('sex', 'Mujer')
            ->whereIn('affiliate_status', ['Activo','Baja por aplicar'])
            ->whereHas('insured.subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $beneficiaryActivosByDateMaleFge = Beneficiary::with('insured.subdependency.dependency')
            ->where('sex', 'Hombre')
            ->whereIn('affiliate_status', ['Activo','Baja por aplicar'])
            ->whereHas('insured.subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $beneficiaryActivosByDateFemaleFge = Beneficiary::with('insured.subdependency.dependency')
            ->where('sex', 'Mujer')
            ->whereIn('affiliate_status', ['Activo','Baja por aplicar'])
            ->whereHas('insured.subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
            $totalBeneficiariesActiveByDateMale= $beneficiaryActivosByDateMaleSsp + $beneficiaryActivosByDateMaleFge;
            $totalBeneficiariesActiveByDateFemale= $beneficiaryActivosByDateFemaleSsp + $beneficiaryActivosByDateFemaleFge;
            $totalBeneficiariesActiveByDateSsp = $beneficiaryActivosByDateMaleSsp + $beneficiaryActivosByDateFemaleSsp;
            $totalBeneficiariesActiveByDateFge = $beneficiaryActivosByDateMaleFge + $beneficiaryActivosByDateFemaleFge;
            $totalBeneficiariesActiveByDate = $totalBeneficiariesActiveByDateSsp + $totalBeneficiariesActiveByDateFge;

        // Pensionados Hombres SSP
         $pensionersTotalByDateMaleSsp = Pensioner::where('sex', 'Hombre')
            ->where('status','Activo')
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        // Pensionados Hombres FGE
         $pensionersTotalByDateMaleFge = Pensioner::where('sex', 'Hombre')
            ->where('status','Activo')
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
          $pensionersTotalByDateMale = $pensionersTotalByDateMaleSsp + $pensionersTotalByDateMaleFge;
          //Pensionados Mujeres SSP
         $pensionersTotalByDateFemaleSsp = Pensioner::where('sex', 'Mujer')
            ->where('status','Activo')
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
            //Pensionados Mujeres FGE
         $pensionersTotalByDateFemaleFge = Pensioner::where('sex', 'Mujer')
            ->where('status','Activo')
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
            $pensionersTotalByDateFemale = $pensionersTotalByDateFemaleSsp + $pensionersTotalByDateFemaleFge;
            $pensionersTotalByDateMaleFemale = $pensionersTotalByDateMale + $pensionersTotalByDateFemale;
            $pensionersTotalByDateSsp = $pensionersTotalByDateMaleSsp + $pensionersTotalByDateFemaleSsp;
            $pensionersTotalByDateFge = $pensionersTotalByDateMaleFge + $pensionersTotalByDateFemaleFge;           
        //Consulta de indicadores 6
        $pensionersByType = Pensioner::where('status', 'Activo')
            ->select('pension_types_id', DB::raw('COUNT(*) as total'))
            ->groupBy('pension_types_id')
            ->with('pensionType:id,name')
            ->whereBetween('start_date', [$inicio, $fin])
            ->get();
        $totalPensioners = $pensionersByType->sum('total');
        //Consulta de indicadores 7
        // $pensionersBeneficiaryByDateMale = PensionerBeneficiary::where('sex', 'Hombre')
        //     ->where('affiliate_status','Activo')
        //     ->whereBetween('start_date',[$inicio, $fin])
        //     ->count();
        // $pensionersBeneficiaryByDateFemale = PensionerBeneficiary::where('sex', 'Mujer')
        //     ->where('affiliate_status','Activo')
        //     ->whereBetween('start_date',[$inicio, $fin])
        //     ->count();
        // $pensionerBeneficiaryTotal= $pensionersBeneficiaryByDateMale+$pensionersBeneficiaryByDateFemale;
        $pensionerBeneficiaryByDateMaleSsp = PensionerBeneficiary::with('pensioner.subdependency.dependency')
            ->where('sex', 'Hombre')
            ->whereIn('affiliate_status', ['Activo','Baja por aplicar'])
            ->whereHas('pensioner.subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $pensionerBeneficiaryByDateFemaleSsp = PensionerBeneficiary::with('pensioner.subdependency.dependency')
            ->where('sex', 'Mujer')
            ->whereIn('affiliate_status', ['Activo','Baja por aplicar'])
            ->whereHas('pensioner.subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $pensionerBeneficiaryByDateMaleFge = PensionerBeneficiary::with('pensioner.subdependency.dependency')
            ->where('sex', 'Hombre')
            ->whereIn('affiliate_status', ['Activo','Baja por aplicar'])
            ->whereHas('pensioner.subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $pensionerBeneficiaryByDateFemaleFge = PensionerBeneficiary::with('pensioner.subdependency.dependency')
            ->where('sex', 'Mujer')
            ->whereIn('affiliate_status', ['Activo','Baja por aplicar'])
            ->whereHas('pensioner.subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->whereBetween('start_date', [$inicio, $fin])
            ->count();
        $pensionersBeneficiaryTotalByDateMale = $pensionerBeneficiaryByDateMaleSsp + $pensionerBeneficiaryByDateMaleFge;
        $pensionersBeneficiaryTotalByDateFemale = $pensionerBeneficiaryByDateFemaleSsp + $pensionerBeneficiaryByDateFemaleFge;
        $pensionerBeneficiaryTotalByDateSsp = $pensionerBeneficiaryByDateMaleSsp + $pensionerBeneficiaryByDateFemaleSsp;
        $pensionerBeneficiaryTotalByDateFge = $pensionerBeneficiaryByDateMaleFge + $pensionerBeneficiaryByDateFemaleFge;
        $pensionerBeneficiaryTotalMaleFemale = $pensionersBeneficiaryTotalByDateMale + $pensionersBeneficiaryTotalByDateFemale;
        //Consulta de indicadores 8

        $insuredsFullTotal = $insuredsActiveTotalByDate + $insuredsPreafiliateTotalByDate;
        // Preparar datos para la vista
        $data = [
            'insuredsActiveTotalByDate' => number_format($insuredsActiveTotalByDate, 0, '.', ','),
            'insuredsPreafiliateTotalByDate' => number_format($insuredsPreafiliateTotalByDate, 0, '.', ','),
            'insuredsFullTotal' => number_format($insuredsFullTotal, 0, '.', ','),
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
            'pensionersTotalByDateMaleSsp' => number_format($pensionersTotalByDateMaleSsp, 0, '.', ','),
            'pensionersTotalByDateMaleFge' => number_format($pensionersTotalByDateMaleFge, 0, '.', ','),
            'pensionersTotalByDateMale' => number_format($pensionersTotalByDateMale, 0, '.', ','),
            'pensionersTotalByDateFemaleSsp' => number_format($pensionersTotalByDateFemaleSsp, 0, '.', ','),
            'pensionersTotalByDateFemaleFge' => number_format($pensionersTotalByDateFemaleFge, 0, '.', ','),
            'pensionersTotalByDateFemale' => number_format($pensionersTotalByDateFemale, 0, '.', ','),
            'pensionersTotalByDateMaleFemale' => number_format($pensionersTotalByDateMaleFemale, 0, '.', ','),
            'pensionersTotalByDateSsp' => number_format($pensionersTotalByDateSsp, 0, '.', ','),
            'pensionersTotalByDateFge' => number_format($pensionersTotalByDateFge, 0, '.', ','),
            'pensionersByType' => $pensionersByType,
            'totalPensioners' => number_format($totalPensioners, 0, '.', ','),
            'pensionerBeneficiaryByDateMaleSsp'=>number_format($pensionerBeneficiaryByDateMaleSsp, 0, '.', ','),
            'pensionerBeneficiaryByDateMaleFge'=>number_format($pensionerBeneficiaryByDateMaleFge, 0, '.', ','),
            'pensionerBeneficiaryByDateFemaleSsp'=> number_format($pensionerBeneficiaryByDateFemaleSsp, 0, '.', ','),
            'pensionerBeneficiaryByDateFemaleFge'=> number_format($pensionerBeneficiaryByDateFemaleFge, 0, '.', ','),
            'pensionerBeneficiaryTotalByDateSsp'=> number_format($pensionerBeneficiaryTotalByDateSsp, 0, '.', ','),
            'pensionerBeneficiaryTotalByDateFge'=> number_format($pensionerBeneficiaryTotalByDateFge, 0, '.', ','),
            'pensionerBeneficiaryTotalMaleFemale'=> number_format($pensionerBeneficiaryTotalMaleFemale, 0, '.', ','),
            'pensionersBeneficiaryTotalByDateMale'=> number_format($pensionersBeneficiaryTotalByDateMale, 0, '.', ','),
            'pensionersBeneficiaryTotalByDateFemale'=> number_format($pensionersBeneficiaryTotalByDateFemale, 0, '.', ','),
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
