<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Livewire\MedicalCoordination\InsuredCredentialsModal;
use App\Livewire\MedicalCoordination\InsuredExpedientModal;
use App\Livewire\MedicalCoordination\InsuredFamiliesModal;
use App\Models\SocioeconomicBenefits\Insured;
use Livewire\Component;
use Livewire\WithPagination;

class Membership extends Component
{
    use WithPagination;

    public $search = '';

    public $numberRows = 10;

    public bool $showingCreateModal = false;

    public ?string $successMessage = null;

    public int $createModalInstance = 0;

    public function openCreateModal(): void
    {
        $this->successMessage = null;
        $this->createModalInstance++;
        $this->showingCreateModal = true;
    }

    public function closeCreateModal(): void
    {
        $this->showingCreateModal = false;
    }

    public function openExpedient(int $insuredId): void
    {
        $this->dispatch('open-medical-insured-expedient', insuredId: $insuredId, origin: 'socioeconomic')
            ->to(InsuredExpedientModal::class);
    }

    public function openFamilies(int $insuredId): void
    {
        $this->dispatch('open-medical-insured-families', insuredId: $insuredId)
            ->to(InsuredFamiliesModal::class);
    }

    public function openCredentials(int $insuredId): void
    {
        $this->dispatch('open-medical-insured-credentials', insuredId: $insuredId)
            ->to(InsuredCredentialsModal::class);
    }

    public function insuredCreated(string $message): void
    {
        $this->successMessage = $message;
        $this->showingCreateModal = false;
        $this->resetPage();
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
        $numberRows = in_array((int) $this->numberRows, [10, 25, 50, 100], true)
            ? (int) $this->numberRows
            : 10;

        $lista = Insured::with('affiliationStatus')
            ->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $term = "%{$term}%";

                    $query->where(function ($q) use ($term) {
                        $q->where('last_name_1', 'like', $term)
                            ->orWhere('last_name_2', 'like', $term)
                            ->orWhere('name', 'like', $term)
                            ->orWhere('employee_number', 'like', $term)
                            ->orWhere('rfc', 'like', $term)
                            ->orWhere('curp', 'like', $term)
                            ->orWhere('file_number', 'like', $term);
                    });
                }
            })
            ->orderBy('file_number', 'asc')
            ->orderBy('id', 'asc')
            ->paginate($numberRows);

        return view('livewire.socioeconomic-benefits.membership', [
            'lista' => $lista,
        ]);
    }
}
