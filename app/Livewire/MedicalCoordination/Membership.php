<?php

namespace App\Livewire\MedicalCoordination;

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
        return view('livewire.medical-coordination.membership',['lista'=>$lista]);
    }
}
