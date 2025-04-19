<?php

namespace App\Modules\Shared\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

trait SoftDeactivatesTrait
{
   protected static function bootSoftDeactivatesTrait()
   {
      static::deleting(function (Model $model) {
         // Si no es una eliminación forzada
         if (! $model->isForceDeleting()) {
            $model->is_active = false;
            $model->save();
         }
      });

      static::restoring(function (Model $model) {
         $model->is_active = true;
      });
   }
}
