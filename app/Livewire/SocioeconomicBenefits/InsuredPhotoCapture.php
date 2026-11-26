<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Insured;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use RuntimeException;
use Throwable;

class InsuredPhotoCapture extends Component
{
    use WithFileUploads;

    private const PHOTO_DIRECTORIES = [
        'fotografias/titulares',
        'fotografias/familiares',
        'fotografias/pensionados',
        'fotografias/familiares-de-pensionados',
    ];

    public bool $isOpen = false;

    public ?array $titular = null;

    public $photo;

    public ?string $currentPhotoUrl = null;

    public ?string $successMessage = null;

    public ?string $uploadError = null;

    #[On('open-insured-photo-capture')]
    public function open(int $insuredId): void
    {
        $this->authorizePhotoAccess();

        $record = Insured::findOrFail($insuredId);

        foreach (self::PHOTO_DIRECTORIES as $directory) {
            Storage::disk('local')->makeDirectory($directory);
        }

        $this->titular = [
            'id' => $record->id,
            'file_number' => $record->file_number,
            'name' => collect([$record->last_name_1, $record->last_name_2, $record->name])
                ->filter(fn ($part) => filled($part))
                ->implode(' '),
        ];
        $this->currentPhotoUrl = $this->photoUrl($record);
        $this->photo = null;
        $this->successMessage = null;
        $this->uploadError = null;
        $this->isOpen = true;
    }

    public function savePhoto(): void
    {
        $this->authorizePhotoAccess();
        $this->resetErrorBag('photo');
        $this->uploadError = null;

        try {
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

            $titularId = $this->titular['id'] ?? null;
            $titular = Insured::findOrFail($titularId);
            $directory = 'fotografias/titulares/'.$titular->id;

            Storage::disk('local')->makeDirectory($directory);

            $extension = match ($this->photo->getMimeType()) {
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
                default => throw ValidationException::withMessages([
                    'photo' => 'El formato de la fotografía no es compatible.',
                ]),
            };

            $newPath = $this->photo->storeAs(
                $directory,
                Str::uuid().'.'.$extension,
                'local'
            );

            if (! $newPath) {
                throw new RuntimeException('No se pudo almacenar la fotografía.');
            }

            try {
                $oldPath = DB::transaction(function () use ($titular, $newPath): ?string {
                    $lockedTitular = Insured::query()->lockForUpdate()->findOrFail($titular->id);
                    $previousPhoto = $lockedTitular->photo;
                    $lockedTitular->photo = $newPath;
                    $lockedTitular->modified_by = auth()->user()->email;
                    $lockedTitular->save();

                    return $previousPhoto;
                }, 3);
            } catch (Throwable $exception) {
                Storage::disk('local')->delete($newPath);
                throw $exception;
            }

            if (
                filled($oldPath)
                && Str::startsWith($oldPath, $directory.'/')
                && $oldPath !== $newPath
            ) {
                Storage::disk('local')->delete($oldPath);
            }

            $this->photo = null;
            $this->currentPhotoUrl = route('socioeconomic_benefits.insured-photo', $titular->id);
            $this->successMessage = 'La fotografía del titular se guardó correctamente.';
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            Log::error('Error al guardar fotografía de titular: '.$exception->getMessage());
            $this->uploadError = 'No se pudo guardar la fotografía. Intenta nuevamente.';
        }
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->titular = null;
        $this->photo = null;
        $this->currentPhotoUrl = null;
        $this->successMessage = null;
        $this->uploadError = null;
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

    private function photoUrl(Insured $titular): string
    {
        if (blank($titular->photo)) {
            return asset('images/icono_no_imagen.png');
        }

        $privatePhotoPrefix = 'fotografias/titulares/'.$titular->id.'/';

        if (Str::startsWith($titular->photo, $privatePhotoPrefix)) {
            return route('socioeconomic_benefits.insured-photo', $titular->id);
        }

        return asset('photo/insureds/'.$titular->file_number.'.jpg');
    }

    public function render()
    {
        return view('livewire.socioeconomic-benefits.insured-photo-capture');
    }
}
