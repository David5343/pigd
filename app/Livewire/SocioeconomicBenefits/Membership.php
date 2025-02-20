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
    public function render()
    {
        $lista = Insured::where('status', 'active')
        ->where(function($query) {
            $query->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('last_name_1', 'like', '%'.$this->search.'%')
                  ->orWhere('last_name_2', 'like', '%'.$this->search.'%')
                  ->orWhere('rfc', 'like', '%'.$this->search.'%');
        })
        ->latest() // Equivalente a orderBy('created_at', 'desc')
        ->take(50) // Tomar solo los últimos 50 registros
        ->paginate($this->numberRows);
        return view('livewire.socioeconomic-benefits.membership',['lista'=>$lista]);
    }
}
