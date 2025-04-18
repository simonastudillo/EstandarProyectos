<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
   protected $commands = [
      \App\Console\Commands\ModelMakeCommand::class,
      \App\Console\Commands\RequestMakeCommand::class,
      \App\Console\Commands\ControllerMakeCommand::class,
   ];

   protected function schedule(Schedule $schedule)
   {
      // Definir tareas programadas si las necesitas
   }

   protected function commands()
   {
      $this->load(__DIR__ . '/Commands');
      require base_path('routes/console.php');
   }
}
