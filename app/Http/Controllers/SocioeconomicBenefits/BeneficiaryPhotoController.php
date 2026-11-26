<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeneficiaryPhotoController extends Controller
{
    public function show(int $beneficiaryId)
    {
        $beneficiary = Beneficiary::findOrFail($beneficiaryId);
        $path = $beneficiary->photo;
        $expectedPrefix = 'fotografias/familiares/'.$beneficiary->id.'/';

        abort_unless(
            filled($path)
                && Str::startsWith($path, $expectedPrefix)
                && ! Str::contains($path, ['../', '..\\']),
            404
        );

        $disk = Storage::disk('local');

        abort_unless($disk->exists($path), 404);

        return response()->file($disk->path($path), [
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
