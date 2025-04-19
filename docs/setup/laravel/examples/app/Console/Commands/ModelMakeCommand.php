<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand as BaseCommand;

class ModelMakeCommand extends BaseCommand
{

   protected function getDefaultNamespace($rootNamespace)
   {
      return $rootNamespace;
   }
}
