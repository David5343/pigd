<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\SocioeconomicBenefits\Insured;

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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Cambiar el estado de los asegurados que llevan más de 60 días en estado "Baja en proceso" a "Baja definitiva"
        
        $limitDate = Carbon::now()->subDays(60);
        Insured::where('affiliation_status_id', 5)
            ->where('inactive_date', '<', $limitDate)
            ->update(['affiliation_status_id' => 4]);
            $this->info('Finalizando bajas en proceso...');
    }
}
