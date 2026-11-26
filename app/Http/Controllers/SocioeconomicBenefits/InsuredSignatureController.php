<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Insured;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InsuredSignatureController extends Controller
{
    public function show(int $insuredId)
    {
        $titular = Insured::findOrFail($insuredId);
        $path = $titular->signature;
        $expectedPrefix = 'firmas/titulares/'.$titular->id.'/';

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
