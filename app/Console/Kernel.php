<?php

namespace App\Console;

use App\Models\TareaProgramada;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:task --scheduled')
                ->everyFiveMinutes()
                ->when(function () {
                    return TareaProgramada::where('fecha_programada', '<=', now())
                        ->where('status', 'pendiente')
                        ->exists();
        })
        ->withoutOverlapping(1500);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
