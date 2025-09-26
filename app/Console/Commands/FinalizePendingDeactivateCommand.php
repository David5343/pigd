<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\SocioeconomicBenefits\Insured;
use App\Models\SocioeconomicBenefits\Beneficiary;
use App\Models\SocioeconomicBenefits\CredentialBeneficiary;
use App\Models\SocioeconomicBenefits\CredentialInsured;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FinalizePendingDeactivateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:finalize-pending-deactivate-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tarea programada que cambia el estado de afiliacion de Baja por aplicar
    => Baja, transcurridos 60 dias, el dia 61 se ejecuta el cambio tanto en titulares
    como en familiares y cambia de estatus a VENCIDA la credencial aunque su estatus sea VIGENTE
    actualizando el campo expirates_at a la fecha del dia 61';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando proceso de actualización...');
        // fecha límite: hace 61 días (solo fecha)
        $limitDate = Carbon::today()->subDays(61);
        $todayString = Carbon::today()->toDateString();

        try {
            DB::beginTransaction();

            // 1. Obtener IDs y actualizar asegurados en un solo paso
            $insuredIds = Insured::where('affiliation_status_id', 5)
                ->whereDate('inactive_date_dependency', '<=', $limitDate->toDateString())
                ->pluck('id'); // aquí sacamos los IDs

            // actualizar asegurados con esos IDs
            $affectedInsureds = Insured::whereIn('id', $insuredIds)
                ->update(['affiliation_status_id' => 4]);

            $this->info("Asegurados actualizados: {$affectedInsureds}");
            // 2. Actualizar credenciales de esos asegurados
            $affectedCredentialInsureds = CredentialInsured::whereIn('insured_id', $insuredIds)
                ->update([
                    'credential_status' => 'VENCIDA',
                    'expires_at' => $todayString,
                ]);

            $this->info("Credenciales de asegurados actualizadas: {$affectedCredentialInsureds}");
            // 3. Obtener IDs y actualizar beneficiarios en un solo paso
            $beneficiaryIds = Beneficiary::where('affiliate_status',  'Baja por aplicar')
                ->whereDate('inactive_date', '<=', $limitDate->toDateString())
                ->pluck('id'); // aquí sacamos los IDs
            // Cambiar estatus de beneficiarios con esos IDs
            $affectedBeneficiaries = Beneficiary::whereIn('id',$beneficiaryIds)
                ->update(['affiliate_status' => 'Baja']);

            $this->info("Beneficiarios actualizados: {$affectedBeneficiaries}");

            // 4. Actualizar credential_beneficiaries (VIGENTE -> VENCIDA) y expires_at = hoy
            $affectedCredentialBeneficiaries = CredentialBeneficiary::WhereIn('beneficiary_id',$beneficiaryIds)
                ->update([
                    'credential_status' => 'VENCIDA',
                    'expires_at' => $todayString,
                ]);

            $this->info("Credenciales de beneficiarios actualizadas: {$affectedCredentialBeneficiaries}");

            DB::commit();

            $this->info('Proceso finalizado correctamente ✅');
            Log::info('Proceso de bajas ejecutado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            $this->error("Error en el proceso: " . $e->getMessage());
            Log::error('Error en proceso de bajas: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
