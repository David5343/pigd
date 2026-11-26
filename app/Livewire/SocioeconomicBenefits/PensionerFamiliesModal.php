<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Pensioner;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class PensionerFamiliesModal extends Component
{
    private const VIEW_ROLES = [
        'JefaturaCoordinacion',
        'PrestacionesSocioEconomicas',
        'JefaturaPrestaciones',
        'SuperAdmin',
    ];

    public bool $isOpen = false;

    #[Locked]
    public ?array $pensionerData = null;

    #[On('open-pensioner-families')]
    public function open(int $pensionerId): void
    {
        abort_unless(auth()->user()?->hasAnyRole(self::VIEW_ROLES), 403);

        $pensioner = Pensioner::query()
            ->whereNull('deleted_at')
            ->with([
                'beneficiaries' => fn ($query) => $query
                    ->whereNull('deleted_at')
                    ->orderBy('file_number')
                    ->orderBy('id'),
            ])
            ->findOrFail($pensionerId);

        $this->pensionerData = [
            'id' => $pensioner->id,
            'noi_number' => $pensioner->noi_number,
            'nombre' => $this->fullName($pensioner->last_name_1, $pensioner->last_name_2, $pensioner->name),
            'familiares' => $pensioner->beneficiaries->map(fn ($beneficiary) => [
                'id' => $beneficiary->id,
                'folio' => $beneficiary->file_number,
                'nombre' => $this->fullName(
                    $beneficiary->last_name_1,
                    $beneficiary->last_name_2,
                    $beneficiary->name
                ),
                'parentesco' => $beneficiary->relationship,
                'curp' => $beneficiary->curp,
                'estatus' => $beneficiary->affiliate_status,
            ])->all(),
        ];
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->pensionerData = null;
    }

    private function fullName(?string $lastName1, ?string $lastName2, ?string $name): string
    {
        return collect([$lastName1, $lastName2, $name])
            ->filter(fn ($part) => filled($part))
            ->implode(' ');
    }

    public function render()
    {
        return view('livewire.socioeconomic-benefits.pensioner-families-modal');
    }
}
