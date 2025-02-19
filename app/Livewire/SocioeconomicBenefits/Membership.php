<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Insured;
use Livewire\Component;
use Livewire\WithPagination;

class Membership extends Component
{
    use WithPagination;
    public function render()
    {
        $lista = Insured::latest()->take(25)->paginate(5);
        return view('livewire.socioeconomic-benefits.membership',['lista'=>$lista]);
    }
}
