<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\RequestMakeCommand as BaseCommand;

class RequestMakeCommand extends BaseCommand
{

   protected function getDefaultNamespace($rootNamespace)
   {
      return $rootNamespace;
   }
}
