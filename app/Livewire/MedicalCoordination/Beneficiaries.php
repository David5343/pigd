<?php

namespace App\Livewire\MedicalCoordination;

use App\Models\SocioeconomicBenefits\Beneficiary;
use Livewire\Component;
use Livewire\WithPagination;

class Beneficiaries extends Component
{
    use WithPagination;

    public $search = '';
    public $numberRows = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingNumberRows(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $terms = preg_split('/\s+/', trim($this->search), -1, PREG_SPLIT_NO_EMPTY);
        $numberRows = in_array((int) $this->numberRows, [10, 25, 50, 100], true)
            ? (int) $this->numberRows
            : 10;

        $query = Beneficiary::query()->where('status', 'active');

        if ($terms !== []) {
            $query->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $term = "%{$term}%";

                    $query->where(function ($query) use ($term) {
                        $query->where('file_number', 'like', $term)
                            ->orWhere('name', 'like', $term)
                            ->orWhere('last_name_1', 'like', $term)
                            ->orWhere('last_name_2', 'like', $term)
                            ->orWhere('curp', 'like', $term);
                    });
                }
            });
        }

        $lista = $query
            ->latest()
            ->orderByDesc('id')
            ->paginate($numberRows);

        return view('livewire.medical-coordination.beneficiaries', [
            'lista' => $lista,
        ]);
    }
}
