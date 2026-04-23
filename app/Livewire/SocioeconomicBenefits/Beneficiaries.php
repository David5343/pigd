<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Beneficiary;
use Livewire\Component;
use Livewire\WithPagination;

class Beneficiaries extends Component
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
    public function getBeneficiaryTotalFathersProperty()
    {
        return Beneficiary::where('relationship','Padre')
                            ->whereIn('affiliate_status',['Activo','Baja por aplicar'])->count();
    }
    public function getBeneficiaryTotalMothersProperty()
    {
        return Beneficiary::where('relationship','Madre')
                            ->whereIn('affiliate_status',['Activo','Baja por aplicar'])->count();
    }
    public function getBeneficiaryTotalChildrenProperty()
    {
        return Beneficiary::where('relationship','Hijo')
                            ->where('sex','Hombre')
                            ->whereIn('affiliate_status',['Activo','Baja por aplicar'])->count();
    }
    public function getBeneficiaryTotalDaughtersProperty()
    {
        return Beneficiary::where('relationship','Hija')
                            ->where('sex','Mujer')
                            ->whereIn('affiliate_status',['Activo','Baja por aplicar'])->count();
    }
    public function getBeneficiaryTotalHusbandsProperty()
    {
        return Beneficiary::where('relationship','Esposo')
                            ->where('sex','Hombre')
                            ->whereIn('affiliate_status',['Activo','Baja por aplicar'])->first();
    }
    public function getBeneficiaryTotalWivesProperty()
    {
        return Beneficiary::where('relationship','Esposa')
                            ->where('sex','Mujer')
                            ->whereIn('affiliate_status',['Activo','Baja por aplicar'])->count();
    }
    public function getBeneficiaryTotalCommonLawMarriageProperty()
    {
        return Beneficiary::where('relationship','Concubina')
                            ->where('sex','Mujer')
                            ->whereIn('affiliate_status',['Activo','Baja por aplicar'])->count();
    }
    public function getBeneficiaryBajasPendientesProperty()
    {
        return Beneficiary::where('affiliate_status','Baja por aplicar')->count();
    }
    public function getBeneficiaryBajasProperty()
    {
        return Beneficiary::where('affiliate_status','Baja')->count();
    }
    public function getBeneficiaryActivosProperty()
    {
        return Beneficiary::whereIn('affiliate_status',['Activo','Baja por aplicar'])->count();
    }
    public function getBeneficiaryTotalProperty()
    {
        return Beneficiary::all()->count();
    }
    public function render()
    {
        $terms = array_filter(explode(' ', trim($this->search)));

        $lista = Beneficiary::where(function ($query) use ($terms) {

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
        return view('livewire.socioeconomic-benefits.beneficiaries',['lista'=>$lista]);
    }
}
