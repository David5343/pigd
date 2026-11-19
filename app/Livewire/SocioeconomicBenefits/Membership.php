<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Insured;
use Livewire\Component;
use Livewire\WithPagination;

class Membership extends Component
{
    use WithPagination;

    public $search = '';
    public $numberRows = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingNumberRows(): void
    {
        $this->resetPage();
    }

    public function getInsuredPreafiliadosProperty()
    {
        return Insured::where('affiliation_status_id', 1)->count();
    }
    public function getInsuredActivosProperty()
    {
        return Insured::whereIn('affiliation_status_id', [1, 2, 5])->count();
    }
    public function getInsuredBajasProperty()
    {
        return Insured::where('affiliation_status_id', 4)->count();
    }
    public function getInsuredBajasPendientesProperty()
    {
        return Insured::where('affiliation_status_id', 5)->count();
    }
    public function getInsuredTotalProperty()
    {
        return Insured::all()->count();
    }
    public function getInsuredTotalHombresProperty()
    {
        return Insured::where('sex', 'Hombre')
            ->whereIn('affiliation_status_id', [1, 2, 5])->count();
    }
    public function getInsuredTotalMujeresProperty()
    {
        return Insured::where('sex', 'Mujer')
            ->whereIn('affiliation_status_id', [1, 2, 5])->count();
    }
    public function getInsuredTotalFGEProperty()
    {
        return Insured::with('subdependency.dependency')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Fiscalia General del Estado');
            })
            ->count();
    }
    public function getInsuredTotalSSPProperty()
    {
        return Insured::with('subdependency.dependency')
            ->whereIn('affiliation_status_id', [1, 2, 5])
            ->whereHas('subdependency.dependency', function ($q) {
                $q->where('name', 'Secretaría de Seguridad del Pueblo');
            })
            ->count();
    }
    public function render()
    {
        $terms = preg_split('/\s+/', trim($this->search), -1, PREG_SPLIT_NO_EMPTY);
        $numberRows = in_array((int) $this->numberRows, [10, 25, 50, 100], true)
            ? (int) $this->numberRows
            : 10;

        $lista = Insured::with('affiliationStatus')
            ->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $term = "%{$term}%";

                    $query->where(function ($q) use ($term) {
                        $q->where('last_name_1', 'like', $term)
                            ->orWhere('last_name_2', 'like', $term)
                            ->orWhere('name', 'like', $term)
                            ->orWhere('employee_number', 'like', $term)
                            ->orWhere('rfc', 'like', $term)
                            ->orWhere('curp', 'like', $term)
                            ->orWhere('file_number', 'like', $term);
                    });
                }
            })
            ->orderBy('file_number', 'asc')
            ->orderBy('id', 'asc')
            ->paginate($numberRows);

        return view('livewire.socioeconomic-benefits.membership', [
            'lista' => $lista,
        ]);
    }
}
