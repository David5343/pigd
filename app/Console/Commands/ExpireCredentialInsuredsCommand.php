<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\SocioeconomicBenefits\CredentialInsured;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpireCredentialInsuredsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-credential-insureds-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambiará de estatus de VIGENTE a VENCIDA si se cumple la condicion';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('✅ Se ejecutó app:expire-credential-insureds-command ' . now());
        $this->info('Iniciando proceso de actualización...');
        $todayString = Carbon::today()->toDateString();

        try {
            DB::beginTransaction();
            $affectedCredentialInsureds = CredentialInsured::where('credential_status', 'VIGENTE')
            ->whereDate('expires_at', '<=', $todayString)
            ->update(['credential_status' => 'VENCIDA']);

            $this->info("Credenciales de asegurados actualizadas: {$affectedCredentialInsureds}");

            DB::commit();

            $this->info('Proceso finalizado correctamente ✅');
            Log::info('Proceso de vencimiento de credenciales ejecutado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            $this->error("Error en el proceso: " . $e->getMessage());
            Log::error('Error en proceso de vencimiento de credenciales: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
