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
    public $option = '';

    public function mount()
    {
        $this->date_start = now()->format('Y-m-d');
        $this->date_end = now()->format('Y-m-d');
    }

    public function generar()
    {
        $this->validate([
            'option' => 'required|in:altas_titulares,bajas_titulares,altas_familiares,bajas_familiares',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
        ]);
        switch ($this->option) {
            case 'altas_titulares':
                return $this->redirect(route('reports.insureds-altas', [
                    'inicio' => $this->date_start,
                    'fin' => $this->date_end,
                ]));

            case 'bajas_titulares':
                return $this->redirect(route('reports.insureds-bajas', [
                    'inicio' => $this->date_start,
                    'fin' => $this->date_end,
                ]));

            case 'altas_familiares':
                return $this->redirect(route('reports.beneficiaries-altas', [
                    'inicio' => $this->date_start,
                    'fin' => $this->date_end,
                ]));
            case 'bajas_familiares':
                return $this->redirect(route('reports.beneficiaries-bajas', [
                    'inicio' => $this->date_start,
                    'fin' => $this->date_end,
                ]));
            default:
                $this->addError('option', 'Seleccione una opción válida.');
                return;
        }
    }
    public function render()
    {
        return view('livewire.socioeconomic-benefits.reports-menu');
    }
}
