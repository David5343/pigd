<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class PensionerImport implements ToCollection, WithHeadingRow, WithMapping
{
    public function collection(Collection $rows)
    {
        $inserted = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            try {
                // Convertir fecha Excel -> Y-m-d
                $fecha = null;
                if (!empty($row['start_date'])) {
                    if (is_numeric($row['start_date'])) {
                        $fecha = Date::excelToDateTimeObject($row['start_date'])->format('Y-m-d');
                    } else {
                        $fecha = Carbon::createFromFormat('d/m/Y', $row['start_date'])->format('Y-m-d');
                    }
                }

                // Insertar fila en la base de datos
                DB::table('pensioners')->insert([
                    'pension_types_id' => $row['pension_types_id'] ?? null,
                    'noi_number'       => $this->formatNoiNumber($row['noi_number'] ?? null),
                    'start_date'       => $fecha,
                    'last_name_1'      => $row['last_name_1'] ?? null,
                    'last_name_2'      => $row['last_name_2'] ?? null,
                    'name'             => $row['name'] ?? null,
                    'rfc'              => $row['rfc'] ?? null,
                    'curp'             => $row['curp'] ?? null,
                    'status'           => $row['status'] ?? null,
                ]);

                $inserted++;
            } catch (\Throwable $e) {
                $fila = $index + 2;
                $mensaje = "Error en fila " . $fila . ": " . $e->getMessage();

                $errors[] = ['fila' => $fila, 'mensaje' => $e->getMessage()];
                Log::error("❌ " . $mensaje);
            }
        }

        if (!empty($errors)) {
            echo "⚠️ Se detectaron " . count($errors) . " errores:\n";
            foreach ($errors as $error) {
                echo "   → Fila {$error['fila']}: {$error['mensaje']}\n";
            }
        }

        echo "✅ Importación finalizada. Registros insertados correctamente: {$inserted}\n";
    }

    /**
     * Forzar formato de noi_number como texto (respetando ceros a la izquierda)
     */
    private function formatNoiNumber($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Si viene como número, lo convertimos a string con ceros a la izquierda (4 dígitos)
        // Ajusta el número 4 según el largo que necesites (por ejemplo 5 → 00001)
        return str_pad((string) $value, 4, '0', STR_PAD_LEFT);
    }

    public function map($row): array
    {
        // Esta función se ejecuta antes de collection()
        // Puedes hacer más transformaciones si lo deseas
        return $row;
    }
}
