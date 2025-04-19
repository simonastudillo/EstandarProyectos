# 🧩 Modelos y Relaciones en Laravel

Esta guía detalla cómo definir modelos en Laravel, aplicando una estructura modular clara y usando convenciones como claves primarias personalizadas, soft deletes y tokens automáticos.

---

> 🔗 [Volver al índice de configuración inicial](./index.md)
> 🔙 [Volver al paso anterior: Migraciones y estructura de tablas](./migrations.md)
> ⏭️ [Ir al paso 11: Aplicar SoftTraits y tokens automáticos](./eloquent-crud.md)

---

## 🛠️ Crear un modelo modular

   ```bash
   php artisan make:model Modules/Pokedex/Models/PokemonModel
   ```

Esto genera:

   ```
   app/Modules/Pokedex/Models/PokemonModel.php
   ```

> 🎯 Convención: usar carpeta por módulo (`Modules/NOMBRE/Models`)  
> 📌 Nombre del modelo debe incluir `Model` al final (`PokemonModel`, `UsersModel`, etc.)

---

---

## 📄 Estructura base recomendada

   ```php
   class PokemonModel extends Model
   {
      use HasFactory, SoftDeletes, SoftDeactivatesTrait;

      protected $table = 'pokemons';
      protected $primaryKey = 'pokemon_id';
      public $timestamps = false;

      protected $fillable = [...];
      protected $guarded = [...];
      protected $casts = [...];

      public static function newFactory()
      {
         return \Database\Factories\PokemonFactory::new();
      }

      public function getRouteKeyName(): string
      {
         return 'pokemon_token';
      }
   }
   ```

---

## 🧩 Traits utilizados

- `HasFactory`: enlaza con un factory
- `SoftDeletes`: habilita el uso de `deleted_at`
- `SoftDeactivatesTrait`: reemplaza `delete()` por `is_active = false` y asigna fecha de baja

---

## 🎯 Clave primaria y tabla personalizada

   ```php
   protected $table = 'pokemons';
   protected $primaryKey = 'pokemon_id';
   ```

---

## 🛡️ Accesores y mutadores (get/set modernos)

Ejemplo para capitalizar nombres:

   ```php
   protected function name(): Attribute
   {
      return Attribute::make(
         get: fn($value) => ucfirst($value),
         set: fn($value) => strtolower($value),
      );
   }
   ```

---

## 🔐 Tokens automáticos

Generación SHA256 desde un UUID:

   ```php
   protected static function booted()
   {
      static::creating(function ($pokemon) {
         $pokemon->pokemon_token = hash('sha256', (string) Str::uuid());
      });
   }
   ```

---

## 🔁 Relaciones entre modelos

   ```php
   // Uno a muchos
   public function evolutions()
   {
      return $this->hasMany(self::class, 'evolves_from', 'pokemon_id')
                  ->where('is_active', true);
   }

   // Inversa
   public function evolvesFrom()
   {
      return $this->belongsTo(self::class, 'evolves_from', 'pokemon_id');
   }
   ```

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

## 🛡️ Reglas y convenciones

- Prefiere `pokemon_id`, `user_id` en vez de `id` para claridad entre tablas.
- Define explícitamente `primaryKey` y `table` si sales de lo convencional.
- Siempre usar `fillable` o `guarded` para proteger la asignación masiva.

---

🔎 **Ejemplo real del proyecto:**  
- [`PokemonModel.php`](./examples/app/Modules/Pokedex/Models/PokemonModel.php)
- [`SoftDeactivatesTrait`](./examples/app/Modules/Shared/Traits/SoftDeactivatesTrait.php)