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
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingnumberRows()
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
        $terms = array_filter(explode(' ', trim($this->search)));

        $lista = Insured::with('affiliationStatus')
            ->where(function ($query) use ($terms) {

                foreach ($terms as $term) {
                    $term = "%{$term}%";

                    $query->where(function ($q) use ($term) {
                        $q->where('last_name_1', 'like', $term)
                        ->orWhere('last_name_2', 'like', $term)
                        ->orWhere('name', 'like', $term)
                        ->orWhere('rfc', 'like', $term)
                        ->orWhere('curp', 'like', $term)
                        ->orWhere('file_number', 'like', $term)
                        ->orWhereRaw(
                            "CONCAT(name, ' ', last_name_1, ' ', last_name_2) LIKE ?",
                            [$term]
                        );
                    });
                }

            })
            ->orderBy('file_number', 'asc')
            ->paginate($this->numberRows);

        return view('livewire.socioeconomic-benefits.membership', [
            'lista' => $lista,
        ]);
    }
}
