<?php

namespace App\Livewire\SocioeconomicBenefits;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BeneficiariesCreate extends Component
{
    #[Validate('required|max:8|unique:beneficiaries,file_number')]
    public $folio;
    public function render()
    {
        $this->folio = IdGenerator::generate(['table' => 'beneficiaries', 'field' => 'file_number', 'length' => 8, 'prefix' => 'F']);
        return view('livewire.socioeconomic-benefits.beneficiaries-create',['folio' => $this->folio]);
    }
}
