<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Beneficiary;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Beneficiaries extends Component
{
    use WithPagination;

    public $search = '';

    public $numberRows = 10;

    public ?string $successMessage = null;

    public string $successTitle = 'Familiar registrado';

    public function openCreateModal(): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'JefaturaCoordinacion',
            'PrestacionesSocioEconomicas',
            'JefaturaPrestaciones',
            'SuperAdmin',
        ]), 403);

        $this->successMessage = null;
        $this->dispatch('open-beneficiary-create-form')
            ->to(BeneficiaryCreateForm::class);
    }

    public function openEditModal(int $beneficiaryId): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'JefaturaCoordinacion',
            'PrestacionesSocioEconomicas',
            'JefaturaPrestaciones',
            'SuperAdmin',
        ]), 403);

        $this->successMessage = null;
        $this->dispatch('open-beneficiary-edit-form', beneficiaryId: $beneficiaryId)
            ->to(BeneficiaryEditForm::class);
    }

    public function openPhotoCapture(int $beneficiaryId): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'JefaturaCoordinacion',
            'PrestacionesSocioEconomicas',
            'JefaturaPrestaciones',
            'SuperAdmin',
        ]), 403);

        $this->dispatch('open-beneficiary-photo-capture', beneficiaryId: $beneficiaryId)
            ->to(BeneficiaryPhotoCapture::class);
    }

    public function openCredentials(int $beneficiaryId): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'JefaturaCoordinacion',
            'PrestacionesSocioEconomicas',
            'JefaturaPrestaciones',
            'SuperAdmin',
        ]), 403);

        $this->dispatch('open-beneficiary-credentials', beneficiaryId: $beneficiaryId)
            ->to(BeneficiaryCredentialsModal::class);
    }

    #[On('beneficiary-created')]
    public function beneficiaryCreated(string $message): void
    {
        $this->successTitle = 'Familiar registrado';
        $this->successMessage = $message;
        $this->search = '';
        $this->resetPage();
    }

    #[On('beneficiary-updated')]
    public function beneficiaryUpdated(string $message): void
    {
        $this->successTitle = 'Familiar actualizado';
        $this->successMessage = $message;
        $this->resetPage();
    }

    public function dismissSuccessModal(): void
    {
        $this->successMessage = null;
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

        $query = Beneficiary::query();

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
                            ->orWhereRaw("CONCAT(name, ' ', last_name_1, ' ', last_name_2) LIKE ?", [$term]);
                    });
                }
            });
        }

        $lista = $query
            ->orderBy('file_number', 'asc')
            ->orderBy('id', 'asc')
            ->paginate($numberRows);

        return view('livewire.socioeconomic-benefits.beneficiaries', [
            'lista' => $lista,
        ]);
    }
}
