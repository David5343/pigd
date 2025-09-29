<?php

use App\Console\Commands\BackupDatabase;
use App\Console\Commands\FinalizePendingDeactivateCommand;
use App\Console\Commands\ExpireCredentialInsuredsCommand;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

//Schedule::command(BackupDatabase::class)->dailyAt('19:00');
Schedule::command(ExpireCredentialInsuredsCommand::class)->dailyAt('07:30');
Schedule::command(FinalizePendingDeactivateCommand::class)->dailyAt('08:00');