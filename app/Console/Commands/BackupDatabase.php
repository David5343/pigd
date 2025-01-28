<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera una copia de seguridad de la base de datosn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbHost = env('DB_HOST');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        
        // Ruta del archivo de respaldo
        $backupFile = 'backup_pigd_' . date('Y-m-d_H-i-s') . '.sql';

        // Ubicación local del respaldo temporal
        $localPath = storage_path('app/backups/' . $backupFile);

        // Comando mysqldump
        $command = sprintf(
            'mysqldump -h %s -u %s -p%s %s > %s',
            escapeshellarg($dbHost),
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbName),
            escapeshellarg($localPath)
        );

        // Ejecutar el comando
        $this->info('Generando respaldo...');
        $output = null;
        $resultCode = null;
        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            $this->error('Error al generar el respaldo.');
            return Command::FAILURE;
        }

        $this->info('Respaldo generado exitosamente.');

        // Copiar el archivo al NAS
        $nasPath = '\\\\192.168.1.65\\pigd\\' . $backupFile;

        $this->info('Copiando respaldo al NAS...');
        $copyCommand = sprintf(
            'copy %s %s',
            escapeshellarg($localPath),
            escapeshellarg($nasPath)
        );

        exec($copyCommand, $output, $resultCode);

        if ($resultCode !== 0) {
            $this->error('Error al copiar el respaldo al NAS.');
            return Command::FAILURE;
        }

        $this->info('Respaldo copiado exitosamente al NAS.');

        // Eliminar archivo temporal
        unlink($localPath);

        return Command::SUCCESS;
    }
}
