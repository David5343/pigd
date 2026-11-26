<?php

namespace App\Services\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Insured;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InsuredCredentialMedia
{
    public function photoDataUri(Insured $insured): ?string
    {
        return $this->dataUri($this->photoPath($insured));
    }

    public function signatureDataUri(Insured $insured): ?string
    {
        return $this->dataUri($this->signaturePath($insured));
    }

    public function hasPhoto(Insured $insured): bool
    {
        return $this->photoPath($insured) !== null;
    }

    public function hasSignature(Insured $insured): bool
    {
        return $this->signaturePath($insured) !== null;
    }

    public function photoPath(Insured $insured): ?string
    {
        return $this->resolvePath(
            $insured->photo,
            'fotografias/titulares/'.$insured->id.'/',
            'fotografias/titulares/'.$insured->id.'/'.$insured->id.'.jpg',
            config('credential_media.legacy_photo_root'),
            $insured->file_number
        );
    }

    public function signaturePath(Insured $insured): ?string
    {
        return $this->resolvePath(
            $insured->signature,
            'firmas/titulares/'.$insured->id.'/',
            'firmas/titulares/'.$insured->id.'/'.$insured->id.'.jpg',
            config('credential_media.legacy_signature_root'),
            $insured->file_number
        );
    }

    public function publicAssetDataUri(string $relativePath): ?string
    {
        $path = public_path($relativePath);

        return $this->dataUri(is_file($path) ? $path : null);
    }

    private function resolvePath(
        ?string $databasePath,
        string $privatePrefix,
        string $idBasedCopy,
        ?string $legacyRoot,
        ?string $fileNumber
    ): ?string {
        $disk = Storage::disk('local');

        if (
            filled($databasePath)
            && Str::startsWith($databasePath, $privatePrefix)
            && $disk->exists($databasePath)
        ) {
            return $disk->path($databasePath);
        }

        if ($disk->exists($idBasedCopy)) {
            return $disk->path($idBasedCopy);
        }

        if (blank($fileNumber) || blank($legacyRoot)) {
            return null;
        }

        $legacyPath = rtrim($legacyRoot, '\\/').DIRECTORY_SEPARATOR.$fileNumber.'.jpg';

        return is_file($legacyPath) ? $legacyPath : null;
    }

    private function dataUri(?string $path): ?string
    {
        if (! $path || ! is_file($path)) {
            return null;
        }

        $contents = @file_get_contents($path);

        if ($contents === false) {
            return null;
        }

        $mimeType = match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'png' => 'image/png',
            'webp' => 'image/webp',
            default => 'image/jpeg',
        };

        return 'data:'.$mimeType.';base64,'.base64_encode($contents);
    }
}
