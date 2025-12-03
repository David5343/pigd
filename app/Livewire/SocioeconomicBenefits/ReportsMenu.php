<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Insured;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class ReportsMenu extends Component
{
    public $date_start = '';

    public $date_end = '';

    public function mount()
    {
        $this->date_start = now()->format('Y-m-d');
        $this->date_end = now()->format('Y-m-d');
    }

    public function generarPDFTitularAltas()
    {
        $inicio = $this->date_start.' 00:00:00';
        $fin = $this->date_end.' 23:59:59';
            $relations = [
                'subdependency',
                'affiliationStatus',
            ];
        $registros = Insured::with($relations)
        ->whereBetween('created_at', [$inicio, $fin])->get();

        $data = [
            'registros' => $registros,
            'fechaInicio' => Carbon::parse($this->date_start)->format('d/m/Y'),
            'fechaFin' => Carbon::parse($this->date_end)->format('d/m/Y'),
            'fechaCreacion' => now()->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('socioeconomic_benefits.reports.insureds.reporte-altas', $data)
            ->setPaper('letter', 'portrait')
            ->setOption('isPhpEnabled', true);

        $pdf->output();

        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->get_canvas();
        $font = $dompdf->getFontMetrics()->get_font('Helvetica', 'normal');

        // Coordenadas
        $w = $canvas->get_width();
        $y = $canvas->get_height() - 40;

        // Pie centrado
        $canvas->page_text(
            $w / 2,
            $y,
            'Página {PAGE_NUM} de {PAGE_COUNT}',
            $font,
            10,
            [0, 0, 0]
        );

        return response()->streamDownload(
            fn () => print ($pdf->output()),
            'reporte-altas.pdf'
        );
    }

    public function render()
    {
        return view('livewire.socioeconomic-benefits.reports-menu');
    }
}
