<?php

namespace App\Console\Commands;

use Illuminate\Routing\Console\ControllerMakeCommand as BaseCommand;

class ControllerMakeCommand extends BaseCommand
{
   protected function getDefaultNamespace($rootNamespace)
   {
      return $rootNamespace; // Esto permite que uses rutas completas como Modules/Pokedex/Controllers
   }
}
