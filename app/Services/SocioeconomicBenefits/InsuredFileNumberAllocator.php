<?php

namespace App\Services\SocioeconomicBenefits;

use Illuminate\Support\Facades\DB;
use RuntimeException;

class InsuredFileNumberAllocator
{
    private const PREFIX = 'T';

    private const SUFFIX_LENGTH = 7;

    public function reserve(string $source): string
    {
        if (! in_array($source, ['web', 'api'], true)) {
            throw new RuntimeException('El origen de la reserva de folio no es válido.');
        }

        return DB::transaction(function () use ($source): string {
            $counter = DB::table('insured_file_number_counters')
                ->where('id', 1)
                ->lockForUpdate()
                ->first();

            if (! $counter) {
                throw new RuntimeException('No se encontró el contador de folios de titulares.');
            }

            $lastNumber = (int) $counter->last_number;

            do {
                $lastNumber++;

                if ($lastNumber > (10 ** self::SUFFIX_LENGTH) - 1) {
                    throw new RuntimeException('Se agotó el rango disponible para generar folios de titulares.');
                }

                $fileNumber = self::PREFIX.str_pad(
                    (string) $lastNumber,
                    self::SUFFIX_LENGTH,
                    '0',
                    STR_PAD_LEFT
                );
            } while (
                DB::table('insureds')->where('file_number', $fileNumber)->exists()
                || DB::table('insured_file_number_reservations')->where('file_number', $fileNumber)->exists()
            );

            DB::table('insured_file_number_counters')
                ->where('id', 1)
                ->update([
                    'last_number' => $lastNumber,
                    'updated_at' => now(),
                ]);

            DB::table('insured_file_number_reservations')->insert([
                'file_number' => $fileNumber,
                'source' => $source,
                'consumed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $fileNumber;
        }, 5);
    }

    public function consume(string $fileNumber, string $source): bool
    {
        if (! in_array($source, ['web', 'api'], true)) {
            return false;
        }

        return DB::transaction(function () use ($fileNumber, $source): bool {
            $reservation = DB::table('insured_file_number_reservations')
                ->where('file_number', $fileNumber)
                ->where('source', $source)
                ->lockForUpdate()
                ->first();

            if (! $reservation || $reservation->consumed_at !== null) {
                return false;
            }

            if (DB::table('insureds')->where('file_number', $fileNumber)->exists()) {
                return false;
            }

            return DB::table('insured_file_number_reservations')
                ->where('id', $reservation->id)
                ->whereNull('consumed_at')
                ->update([
                    'consumed_at' => now(),
                    'updated_at' => now(),
                ]) === 1;
        }, 5);
    }
}
