<?php

namespace App\Console\Commands;

use App\Models\SocioeconomicBenefits\Insured;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class MigrateInsuredMediaToPrivateStorage extends Command
{
    protected $signature = 'app:migrate-insured-media
        {--photo-source= : Directorio de fotos legado (contiene {folio}.jpg)}
        {--signature-source= : Directorio de firmas legado (contiene {folio}.jpg)}
        {--apply : Copiar archivos y actualizar los campos photo/signature; por defecto solo simula}';

    protected $description = 'Copia fotos y firmas legadas de titulares a rutas privadas basadas en el ID del registro.';

    private array $counts = [
        'titulares' => 0,
        'foto_copiar' => 0,
        'foto_ya_migrada' => 0,
        'foto_faltante' => 0,
        'foto_sin_referencia' => 0,
        'foto_folio_duplicado' => 0,
        'foto_conflicto' => 0,
        'firma_copiar' => 0,
        'firma_ya_migrada' => 0,
        'firma_faltante' => 0,
        'firma_sin_referencia' => 0,
        'firma_folio_duplicado' => 0,
        'firma_conflicto' => 0,
        'errores' => 0,
    ];

    public function handle(): int
    {
        $photoSource = $this->option('photo-source') ?: env('LEGACY_INSURED_PHOTOS_PATH');
        $signatureSource = $this->option('signature-source') ?: env('LEGACY_INSURED_SIGNATURES_PATH');

        if (! $photoSource || ! is_dir($photoSource)) {
            $this->error('No se puede acceder al directorio de fotos legado. Indica --photo-source.');

            return self::FAILURE;
        }

        if (! $signatureSource || ! is_dir($signatureSource)) {
            $this->error('No se puede acceder al directorio de firmas legado. Indica --signature-source.');

            return self::FAILURE;
        }

        if ($this->output->isVerbose()) {
            $this->line('Directorio de fotos: '.$photoSource);
            $this->line('Directorio de firmas: '.$signatureSource);
        }

        $apply = (bool) $this->option('apply');
        $this->info($apply
            ? 'Modo aplicación: se copiarán archivos y actualizarán las rutas photo/signature en la base de datos.'
            : 'Modo simulación: no se copiarán archivos ni se modificarán registros. Usa --apply para aplicar.');
        $this->line('Los archivos de origen del NAS no se modificarán ni eliminarán.');

        $duplicateFolios = DB::table('insureds')
            ->select('file_number')
            ->whereNotNull('file_number')
            ->where('file_number', '<>', '')
            ->groupBy('file_number')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('file_number')
            ->flip();

        Insured::query()
            ->select(['id', 'file_number', 'photo', 'signature'])
            ->orderBy('id')
            ->chunkById(200, function ($titulares) use ($photoSource, $signatureSource, $apply, $duplicateFolios): void {
                foreach ($titulares as $titular) {
                    $this->counts['titulares']++;

                    if (blank($titular->file_number)) {
                        $this->counts[filled($titular->photo) ? 'foto_faltante' : 'foto_sin_referencia']++;
                        $this->counts[filled($titular->signature) ? 'firma_faltante' : 'firma_sin_referencia']++;

                        continue;
                    }

                    if ($duplicateFolios->has($titular->file_number)) {
                        $this->counts[filled($titular->photo) ? 'foto_folio_duplicado' : 'foto_sin_referencia']++;
                        $this->counts[filled($titular->signature) ? 'firma_folio_duplicado' : 'firma_sin_referencia']++;

                        continue;
                    }

                    $this->migrateFile(
                        $titular,
                        'photo',
                        $photoSource,
                        'fotografias/titulares',
                        'foto',
                        $apply
                    );
                    $this->migrateFile(
                        $titular,
                        'signature',
                        $signatureSource,
                        'firmas/titulares',
                        'firma',
                        $apply
                    );
                }
            });

        $this->newLine();
        $this->table(
            [
                'Elemento',
                'Copiar / actualizar',
                'Ya migrado',
                'Archivo faltante',
                'Sin referencia DB',
                'Folio duplicado',
                'Conflicto',
            ],
            [
                [
                    'Fotos',
                    $this->counts['foto_copiar'],
                    $this->counts['foto_ya_migrada'],
                    $this->counts['foto_faltante'],
                    $this->counts['foto_sin_referencia'],
                    $this->counts['foto_folio_duplicado'],
                    $this->counts['foto_conflicto'],
                ],
                [
                    'Firmas',
                    $this->counts['firma_copiar'],
                    $this->counts['firma_ya_migrada'],
                    $this->counts['firma_faltante'],
                    $this->counts['firma_sin_referencia'],
                    $this->counts['firma_folio_duplicado'],
                    $this->counts['firma_conflicto'],
                ],
            ]
        );
        $this->line('Titulares revisados: '.$this->counts['titulares']);

        if ($this->counts['errores'] > 0) {
            $this->warn('Se detectaron '.$this->counts['errores'].' errores; revisa el log antes de reintentar.');

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function migrateFile(
        Insured $titular,
        string $column,
        string $sourceRoot,
        string $baseDirectory,
        string $kind,
        bool $apply
    ): void {
        $counterPrefix = $kind === 'foto' ? 'foto' : 'firma';
        $privatePrefix = $baseDirectory.'/'.$titular->id.'/';
        $currentPath = $titular->{$column};
        $disk = Storage::disk('local');

        if (filled($currentPath) && Str::startsWith($currentPath, $privatePrefix) && $disk->exists($currentPath)) {
            $this->counts[$counterPrefix.'_ya_migrada']++;

            return;
        }

        if (blank($currentPath)) {
            $this->counts[$counterPrefix.'_sin_referencia']++;

            return;
        }

        $folio = trim((string) $titular->file_number);

        if (Str::contains($folio, ['../', '..\\', '/', '\\'])) {
            $this->counts['errores']++;

            return;
        }

        $sourcePath = rtrim($sourceRoot, '\\/').DIRECTORY_SEPARATOR.$folio.'.jpg';
        if (! is_file($sourcePath)) {
            $this->counts[$counterPrefix.'_faltante']++;

            return;
        }

        $targetPath = $baseDirectory.'/'.$titular->id.'/'.$titular->id.'.jpg';
        $this->counts[$counterPrefix.'_copiar']++;

        if (! $apply) {
            return;
        }

        $targetAlreadyExists = $disk->exists($targetPath);

        try {
            if (! $targetAlreadyExists) {
                $disk->makeDirectory(dirname($targetPath));
                $contents = file_get_contents($sourcePath);

                if ($contents === false || ! $disk->put($targetPath, $contents)) {
                    throw new RuntimeException('No se pudo copiar el archivo de origen.');
                }
            }

            $updated = DB::table('insureds')
                ->where('id', $titular->id)
                ->where($column, $currentPath)
                ->update([$column => $targetPath]);

            if ($updated === 0) {
                $latestPath = DB::table('insureds')->where('id', $titular->id)->value($column);

                if ($latestPath !== $targetPath) {
                    $this->counts[$counterPrefix.'_conflicto']++;

                    if (! $targetAlreadyExists) {
                        $disk->delete($targetPath);
                    }

                    return;
                }
            }
        } catch (Throwable) {
            $this->counts['errores']++;

            if (! $targetAlreadyExists) {
                $disk->delete($targetPath);
            }
        }
    }
}
