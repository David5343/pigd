<?php

namespace Database\Seeders;

use App\Imports\PensionerImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Throwable;

class InsertPensionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/cargar_pensionados.xlsx');

        try {
            Excel::import(new PensionerImport, $path);
            $this->command->info('✅ Datos importados correctamente desde el archivo Excel.');
        } catch (Throwable $e) {
            Log::error('❌ Error al importar Excel en InsertPensionerSeeder: ' . $e->getMessage());
            $this->command->error('Error: ' . $e->getMessage());
        }
    }
}
