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
    public function getBeneficiaryActivosProperty()
    {
        return Beneficiary::where('affiliate_status','Activo')->count();
    }
    public function getBeneficiaryBajasProperty()
    {
        return Beneficiary::where('affiliate_status','Baja')->count();
    }
    public function getBeneficiaryBajasPendientesProperty()
    {
        return Beneficiary::where('affiliate_status','Baja por Aplicar')->count();
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
