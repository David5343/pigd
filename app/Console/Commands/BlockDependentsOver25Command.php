<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\SocioeconomicBenefits\Beneficiary;
use App\Models\SocioeconomicBenefits\CredentialBeneficiary;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlockDependentsOver25Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:block-dependents-over-25-command';

    /**
     * The console command description.
     *
     * @var string
     */
protected $description = 'Bloquea familiares mayores de 25 años y vence sus credenciales vigentes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('✅ Se ejecutó app:block-dependents-over-25-command ' . now());
        $this->info('Iniciando proceso de actualización...');
        // fecha límite: hace 61 días (solo fecha)
        $limitDate = Carbon::today()->subDays(61);
        $todayString = Carbon::today()->toDateString();

        try {
            DB::beginTransaction();
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
