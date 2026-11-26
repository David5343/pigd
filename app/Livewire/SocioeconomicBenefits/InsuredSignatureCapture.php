<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Insured;
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

class InsuredSignatureCapture extends Component
{
    use WithFileUploads;

    public bool $isOpen = false;

    #[Locked]
    public ?array $titular = null;

    public $signatureImage;

    public ?string $currentSignatureUrl = null;

    public bool $hasLegacySignature = false;

    public ?string $successMessage = null;

    public ?string $captureError = null;

    public ?string $uploadError = null;

    #[On('open-insured-signature-capture')]
    public function open(int $insuredId): void
    {
        $this->authorizeSignatureAccess();

        $record = Insured::findOrFail($insuredId);

        $this->titular = [
            'id' => $record->id,
            'file_number' => $record->file_number,
            'name' => collect([$record->last_name_1, $record->last_name_2, $record->name])
                ->filter(fn ($part) => filled($part))
                ->implode(' '),
        ];
        $this->currentSignatureUrl = $this->signatureUrl($record);
        $this->hasLegacySignature = filled($record->signature) && $this->currentSignatureUrl === null;
        $this->signatureImage = null;
        $this->successMessage = null;
        $this->captureError = null;
        $this->uploadError = null;
        $this->isOpen = true;
    }

    public function saveSignature(): void
    {
        $this->authorizeSignatureAccess();
        $this->resetErrorBag('signatureImage');
        $this->uploadError = null;

        try {
            $this->validate([
                'signatureImage' => ['required', 'image', 'mimes:png', 'max:4096'],
            ], [
                'signatureImage.required' => 'Captura la firma antes de guardarla.',
                'signatureImage.image' => 'El archivo de firma no es una imagen válida.',
                'signatureImage.mimes' => 'La firma debe recibirse en formato PNG.',
                'signatureImage.max' => 'La firma no debe superar los 4 MB.',
            ], [
                'signatureImage' => 'firma',
            ]);

            $titularId = $this->titular['id'] ?? null;
            $titular = Insured::findOrFail($titularId);
            $directory = 'firmas/titulares/'.$titular->id;
            $disk = Storage::disk('local');
            $disk->makeDirectory($directory);

            $newPath = $this->signatureImage->storeAs(
                $directory,
                Str::uuid().'.png',
                'local'
            );

            if (! $newPath) {
                throw new RuntimeException('No se pudo almacenar la firma.');
            }

            try {
                $oldPath = DB::transaction(function () use ($titular, $newPath): ?string {
                    $lockedTitular = Insured::query()->lockForUpdate()->findOrFail($titular->id);
                    $previousSignature = $lockedTitular->signature;
                    $lockedTitular->signature = $newPath;
                    $lockedTitular->modified_by = auth()->user()->email;
                    $lockedTitular->save();

                    return $previousSignature;
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

            $this->signatureImage = null;
            $this->currentSignatureUrl = route('socioeconomic_benefits.insured-signature', $titular->id);
            $this->successMessage = 'La firma del titular se guardó correctamente.';
            $this->captureError = null;
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            Log::error('Error al guardar firma de titular: '.$exception->getMessage());
            $this->uploadError = 'No se pudo guardar la firma. Intenta nuevamente.';
        }
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->titular = null;
        $this->signatureImage = null;
        $this->currentSignatureUrl = null;
        $this->hasLegacySignature = false;
        $this->successMessage = null;
        $this->captureError = null;
        $this->uploadError = null;
    }

    private function authorizeSignatureAccess(): void
    {
        abort_unless(auth()->user()?->hasAnyRole([
            'JefaturaCoordinacion',
            'PrestacionesSocioEconomicas',
            'JefaturaPrestaciones',
            'SuperAdmin',
        ]), 403);
    }

    private function signatureUrl(Insured $titular): ?string
    {
        $signaturePrefix = 'firmas/titulares/'.$titular->id.'/';

        return filled($titular->signature) && Str::startsWith($titular->signature, $signaturePrefix)
            ? route('socioeconomic_benefits.insured-signature', $titular->id)
            : null;
    }

    public function render()
    {
        return view('livewire.socioeconomic-benefits.insured-signature-capture');
    }
}
