<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Pensioner;
use Livewire\Component;
use Livewire\WithPagination;

class Pensioners extends Component
{
    use WithPagination;

    public string $search = '';

    public int $numberRows = 10;

    public function openFamilies(int $pensionerId): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'JefaturaCoordinacion',
            'PrestacionesSocioEconomicas',
            'JefaturaPrestaciones',
            'SuperAdmin',
        ]), 403);

        $this->dispatch('open-pensioner-families', pensionerId: $pensionerId)
            ->to(PensionerFamiliesModal::class);
    }

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

        $lista = Pensioner::query()
            ->with('pensionType')
            ->whereNull('deleted_at')
            ->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $term = "%{$term}%";

                    $query->where(function ($q) use ($term) {
                        $q->where('noi_number', 'like', $term)
                            ->orWhere('last_name_1', 'like', $term)
                            ->orWhere('last_name_2', 'like', $term)
                            ->orWhere('name', 'like', $term)
                            ->orWhere('rfc', 'like', $term)
                            ->orWhere('curp', 'like', $term)
                            ->orWhereHas('pensionType', fn ($typeQuery) => $typeQuery->where('name', 'like', $term));
                    });
                }
            })
            ->orderBy('noi_number')
            ->orderBy('id')
            ->paginate($numberRows);

        return view('livewire.socioeconomic-benefits.pensioners', [
            'lista' => $lista,
        ]);
    }
}
