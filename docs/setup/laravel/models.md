# 🧩 Modelos y Relaciones en Laravel

Esta guía detalla cómo definir modelos en Laravel, aplicando una estructura modular clara y usando convenciones como claves primarias personalizadas, soft deletes y tokens automáticos.

---

> 🔗 [Volver al índice de configuración inicial](./index.md)  
> 🔙 [Volver al paso anterior: Migraciones y estructura de tablas](./migrations.md)  
> ⏭️ [Ir al paso 11: Aplicar SoftTraits y tokens automáticos](./traits-and-tokens.md)

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

## 🛡️ Reglas y convenciones

- Prefiere `pokemon_id`, `user_id` en vez de `id` para claridad entre tablas.
- Define explícitamente `primaryKey` y `table` si sales de lo convencional.
- Siempre usar `fillable` o `guarded` para proteger la asignación masiva.

---

🔎 **Ejemplo real del proyecto:**  
- [`PokemonModel.php`](./examples/app/Modules/Pokedex/Models/PokemonModel.php)