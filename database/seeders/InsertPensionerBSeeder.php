<?php

namespace Database\Seeders;

use App\Imports\PensionerBImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class InsertPensionerBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/cargar_pensionados.xlsx');
                try {
            Excel::import(new PensionerBImport, $path);
            $this->command->info('✅ Datos importados correctamente desde el archivo Excel.');
        } catch (Throwable $e) {
            Log::error('❌ Error al importar Excel en InsertPensionerBSeeder: ' . $e->getMessage());
            $this->command->error('Error: ' . $e->getMessage());
        }
    }
}
