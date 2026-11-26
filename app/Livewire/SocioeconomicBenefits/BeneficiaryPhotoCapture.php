<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Beneficiary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use RuntimeException;
use Throwable;

class BeneficiaryPhotoCapture extends Component
{
    use WithFileUploads;

    public bool $isOpen = false;

    #[Locked]
    public ?array $familiar = null;

    public $photo;

    public ?string $currentPhotoUrl = null;

    public ?string $successMessage = null;

    public ?string $uploadError = null;

    #[On('open-beneficiary-photo-capture')]
    public function open(int $beneficiaryId): void
    {
        $this->authorizePhotoAccess();

        $beneficiary = Beneficiary::findOrFail($beneficiaryId);

        $this->familiar = [
            'id' => $beneficiary->id,
            'file_number' => $beneficiary->file_number,
            'name' => collect([$beneficiary->last_name_1, $beneficiary->last_name_2, $beneficiary->name])
                ->filter(fn ($part) => filled($part))
                ->implode(' '),
        ];
        $this->currentPhotoUrl = $this->photoUrl($beneficiary);
        $this->photo = null;
        $this->successMessage = null;
        $this->uploadError = null;
        $this->isOpen = true;
    }

    public function savePhoto(): void
    {
        $this->authorizePhotoAccess();
        abort_unless($this->isOpen && $this->familiar, 404);

        $this->resetErrorBag('photo');
        $this->uploadError = null;

        $this->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'photo.required' => 'Selecciona o captura una fotografía antes de guardarla.',
            'photo.image' => 'El archivo debe ser una imagen válida.',
            'photo.mimes' => 'La fotografía debe estar en formato JPG, PNG o WebP.',
            'photo.max' => 'La fotografía no debe superar los 5 MB.',
        ], [
            'photo' => 'fotografía',
        ]);

        try {
            $beneficiary = Beneficiary::findOrFail($this->familiar['id']);
            $directory = 'fotografias/familiares/'.$beneficiary->id;
            $disk = Storage::disk('local');
            $disk->makeDirectory($directory);

            $extension = match ($this->photo->getMimeType()) {
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
                default => throw ValidationException::withMessages([
                    'photo' => 'El formato de la fotografía no es compatible.',
                ]),
            };

            $newPath = $this->photo->storeAs($directory, Str::uuid().'.'.$extension, 'local');

            if (! $newPath) {
                throw new RuntimeException('No se pudo almacenar la fotografía.');
            }

            try {
                $oldPath = DB::transaction(function () use ($beneficiary, $newPath): ?string {
                    $lockedBeneficiary = Beneficiary::query()->lockForUpdate()->findOrFail($beneficiary->id);
                    $previousPhoto = $lockedBeneficiary->photo;
                    $lockedBeneficiary->photo = $newPath;
                    $lockedBeneficiary->modified_by = auth()->user()->email;
                    $lockedBeneficiary->save();

                    return $previousPhoto;
                }, 3);
            } catch (Throwable $exception) {
                $disk->delete($newPath);
                throw $exception;
            }

            if (
                filled($oldPath)
                && Str::startsWith($oldPath, $directory.'/')
                && $oldPath !== $newPath
            ) {
                $disk->delete($oldPath);
            }

            $this->photo = null;
            $this->currentPhotoUrl = route('socioeconomic_benefits.beneficiary-photo', $beneficiary->id);
            $this->successMessage = 'La fotografía del familiar se guardó correctamente.';
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            Log::error('Error al guardar fotografía de familiar.', [
                'exception' => $exception::class,
            ]);
            $this->uploadError = 'No se pudo guardar la fotografía. Intenta nuevamente.';
        }
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->familiar = null;
        $this->photo = null;
        $this->currentPhotoUrl = null;
        $this->successMessage = null;
        $this->uploadError = null;
        $this->resetValidation();
    }

    private function authorizePhotoAccess(): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'JefaturaCoordinacion',
            'PrestacionesSocioEconomicas',
            'JefaturaPrestaciones',
            'SuperAdmin',
        ]), 403);
    }

    private function photoUrl(Beneficiary $beneficiary): string
    {
        if (blank($beneficiary->photo)) {
            return asset('images/icono_no_imagen.png');
        }

        $privatePhotoPrefix = 'fotografias/familiares/'.$beneficiary->id.'/';

        if (Str::startsWith($beneficiary->photo, $privatePhotoPrefix)) {
            return route('socioeconomic_benefits.beneficiary-photo', $beneficiary->id);
        }

        return asset('photo/beneficiaries/'.$beneficiary->file_number.'.jpg');
    }

    public function render()
    {
        return view('livewire.socioeconomic-benefits.beneficiary-photo-capture');
    }
}
