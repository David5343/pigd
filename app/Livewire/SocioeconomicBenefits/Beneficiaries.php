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
                            ->where('affiliate_status','Activo')->count();
    }
    public function getBeneficiaryTotalMothersProperty()
    {
        return Beneficiary::where('relationship','Madre')
                            ->where('affiliate_status','Activo')->count();
    }
    public function getBeneficiaryTotalChildrenProperty()
    {
        return Beneficiary::where('relationship','Hijo')
                            ->where('sex','Hombre')
                            ->where('affiliate_status','Activo')->count();
    }
    public function getBeneficiaryTotalDaughtersProperty()
    {
        return Beneficiary::where('relationship','Hija')
                            ->where('sex','Mujer')
                            ->where('affiliate_status','Activo')->count();
    }
    public function getBeneficiaryTotalHusbandsProperty()
    {
        return Beneficiary::where('relationship','Esposo')
                            ->where('sex','Hombre')
                            ->where('affiliate_status','Activo')->first();
    }
    public function getBeneficiaryTotalWivesProperty()
    {
        return Beneficiary::where('relationship','Esposa')
                            ->where('sex','Mujer')
                            ->where('affiliate_status','Activo')->count();
    }
    public function getBeneficiaryTotalCommonLawMarriageProperty()
    {
        return Beneficiary::where('relationship','Concubina')
                            ->where('sex','Mujer')
                            ->where('affiliate_status','Activo')->count();
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
        $lista = Beneficiary::where(function($query) {
            $query->where('file_number', 'like', '%'.$this->search.'%')
                  ->orWhere('name', 'like', '%'.$this->search.'%')
                  ->orWhere('last_name_1', 'like', '%'.$this->search.'%')
                  ->orWhere('last_name_2', 'like', '%'.$this->search.'%')
                  ->orWhere('curp', 'like', '%'.$this->search.'%');
        })
        ->orderBy('file_number', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.socioeconomic-benefits.beneficiaries',['lista'=>$lista]);
    }
}
