<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Insured;
use Livewire\Component;
use Livewire\WithPagination;

class Membership extends Component
{
    use WithPagination;
    public $query = '';
    public $numberRows = 10;
    public function search()
    {
        $this->resetPage();
    }
    public function render()
    {
        $lista = Insured::where('status', 'active')
        ->where(function($query) {
            $query->where('name', 'like', '%'.$this->query.'%')
                  ->orWhere('last_name_1', 'like', '%'.$this->query.'%')
                  ->orWhere('last_name_2', 'like', '%'.$this->query.'%');
        })
        ->latest() // Equivalente a orderBy('created_at', 'desc')
        ->take(50) // Tomar solo los últimos 50 registros
        ->paginate($this->numberRows);
        return view('livewire.socioeconomic-benefits.membership',['lista'=>$lista]);
    }
}
