<?php

use App\Console\Commands\BackupDatabase;
use App\Console\Commands\FinalizePendingDeactivateCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

//Schedule::command(BackupDatabase::class)->dailyAt('19:00');
//Schedule::command(FinalizePendingDeactivateCommand::class)->dailyAt('08:00');
Schedule::command(FinalizePendingDeactivateCommand::class)->everyMinute();