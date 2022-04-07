<?php

namespace App\Console;

use App\Console\Commands\DeleteEmptyAgreements;
use App\Console\Commands\DeleteEmptyRequisitions;
use App\Console\Commands\FetchDailyTransactions;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        DeleteEmptyAgreements::class,
        DeleteEmptyRequisitions::class,
        FetchDailyTransactions::class,
    ];
    
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:delete.empty.agreements')->daily()->withoutOverlapping()->runInBackground();
        $schedule->command('command:delete.empty.requisitions')->daily()->withoutOverlapping()->runInBackground();
        $schedule->command('command:fetch.daily.transactions')->twiceDaily()->withoutOverlapping()->runInBackground();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
