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
    public function getInsuredPreProperty()
    {
        return Insured::where('affiliation_status_id',1)->count();
    }
    public function getInsuredActivosProperty()
    {
        return Insured::where('affiliation_status_id',2)->count();
    }
    public function getInsuredBajasProperty()
    {
        return Insured::where('affiliation_status_id',4)->count();
    }
    public function getInsuredBajasPendientesProperty()
    {
        return Insured::where('affiliation_status_id',5)->count();
    }
    public function getInsuredTotalProperty()
    {
        return Insured::all()->count();
    }
    public function getInsuredTotalHombresProperty()
    {
        return Insured::where('sex','Hombre')->count();
    }
    public function getInsuredTotalMujeresProperty()
    {
        return Insured::where('sex','Mujer')->count();
    }
    public function render()
    {
        // $lista = Insured::where('status', 'active')
        $lista = Insured::with('affiliationStatus')->where(function($query) {
            $query->where('file_number', 'like', '%'.$this->search.'%')
                  ->orWhere('name', 'like', '%'.$this->search.'%')
                  ->orWhere('last_name_1', 'like', '%'.$this->search.'%')
                  ->orWhere('last_name_2', 'like', '%'.$this->search.'%')
                  ->orWhere('rfc', 'like', '%'.$this->search.'%')
                  ->orWhere('curp', 'like', '%'.$this->search.'%');
        })
        ->orderBy('file_number', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.socioeconomic-benefits.membership',['lista'=>$lista]);
    }
}
