<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\PensionerBeneficiary;
use Livewire\Component;
use Livewire\WithPagination;

class PensionerBeneficiaries extends Component
{
    use WithPagination;

    public string $search = '';

    public int $numberRows = 10;

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
        $numberRows = in_array($this->numberRows, [10, 25, 50, 100], true)
            ? $this->numberRows
            : 10;

        $query = PensionerBeneficiary::query()
            ->with(['pensioner' => fn ($query) => $query->whereNull('deleted_at')])
            ->whereNull('deleted_at');

        if ($terms !== []) {
            $query->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $term = "%{$term}%";

                    $query->where(function ($q) use ($term) {
                        $q->where('file_number', 'like', $term)
                            ->orWhere('name', 'like', $term)
                            ->orWhere('last_name_1', 'like', $term)
                            ->orWhere('last_name_2', 'like', $term)
                            ->orWhere('rfc', 'like', $term)
                            ->orWhere('curp', 'like', $term)
                            ->orWhere('relationship', 'like', $term)
                            ->orWhereHas('pensioner', function ($pensionerQuery) use ($term) {
                                $pensionerQuery->whereNull('deleted_at')
                                    ->where(function ($relatedQuery) use ($term) {
                                        $relatedQuery->where('noi_number', 'like', $term)
                                            ->orWhere('name', 'like', $term)
                                            ->orWhere('last_name_1', 'like', $term)
                                            ->orWhere('last_name_2', 'like', $term);
                                    });
                            });
                    });
                }
            });
        }

        $lista = $query
            ->orderBy('file_number')
            ->orderBy('id')
            ->paginate($numberRows);

        return view('livewire.socioeconomic-benefits.pensioner-beneficiaries', [
            'lista' => $lista,
        ]);
    }
}
