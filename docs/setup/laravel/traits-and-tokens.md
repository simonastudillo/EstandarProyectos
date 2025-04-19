# 🧩 Aplicar SoftTraits y Tokens Automáticos

Esta sección explica cómo integrar soft deletes personalizados (`is_active`) y la generación automática de tokens para identificar registros mediante rutas o claves externas.

---

> 🔗 [Volver al índice de configuración inicial](./index.md)  
> 🔙 [Volver al paso anterior: Modelos y relaciones](./models.md)  
> ⏭️ [Ir al paso 12: Factories y generación de datos](./factories.md)

---

## 🧪 Soft delete personalizado con SoftDeactivatesTrait

El trait `SoftDeactivatesTrait` permite que al eliminar un modelo, en lugar de borrarlo, se establezca `is_active = false` y opcionalmente se actualice el campo `deleted_at`.

### Implementación en el modelo

   ```php
   use App\Modules\Shared\Traits\SoftDeactivatesTrait;

   class PokemonModel extends Model
   {
      use HasFactory, SoftDeletes, SoftDeactivatesTrait;
   }
   ```

> 📌 Requiere el campo `is_active` y `deleted_at` en la tabla.

---

## 🧩 Traits utilizados

- `HasFactory`: enlaza con un factory
- `SoftDeletes`: habilita el uso de `deleted_at`
- `SoftDeactivatesTrait`: reemplaza `delete()` por `is_active = false` y asigna fecha de baja

---

### 🧩 Trait personalizado: SoftDeactivatesTrait

Permite manejar "soft deletes" mediante un campo booleano `is_active` en lugar del típico `deleted_at`.

   ```php
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
   ```

Este trait:

- Al hacer `delete()`, marca `is_active = false`
- Al hacer `restore()`, vuelve `is_active = true`
- Y además, asigna la fecha actual al campo `deleted_at`, si está definido

> ⚠️ Es necesario que el modelo tenga el campo `deleted_at` y lo incluya en `$dates` si se desea mantener la fecha de inactivación como referencia adicional.

---

## 🔐 Generación de token automático

Este patrón genera un token único y seguro (`pokemon_token`) antes de insertar el registro en base de datos.

### Implementación en el modelo

   ```php
   use Illuminate\Support\Str;

   protected static function booted()
   {
      static::creating(function ($model) {
         $model->pokemon_token = hash('sha256', (string) Str::uuid());
      });
   }
   ```

> ⚠️ Asegurate de tener el campo `pokemon_token` definido como único e indexado.

---

## 🧪 Ejemplo real del proyecto

- [`SoftDeactivatesTrait`](./examples/app/Modules/Shared/Traits/SoftDeactivatesTrait.php)
- [`PokemonModel.php`](./examples/app/Modules/Pokedex/Models/PokemonModel.php)
