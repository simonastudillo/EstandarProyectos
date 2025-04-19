# 🧪 Factories en Laravel

Los factories permiten generar datos aleatorios de prueba o desarrollo, útiles para alimentar la base de datos mediante seeders o directamente desde tests.

---

> 🔗 [Volver al índice de configuración inicial](./index.md)
> 🔙 [Volver al paso anterior: Aplicar SoftTraits y tokens automáticos](./traits-and-tokens.md)
> ⏭️ [Ir al paso 12: Seeders con datos base](./seeders.md)

---

## 🛠️ Crear un factory

   ```bash
   php artisan make:factory PokemonFactory
   ```

Esto genera un archivo en:

   ```
   database/factories/PokemonFactory.php
   ```

---

## 🔧 Estructura recomendada

   ```php
   use Illuminate\Support\Str;

   protected $model = \App\Modules\Pokedex\Models\PokemonModel::class;

   public function definition()
   {
      return [
         'name' => $this->faker->word(),
         'level' => $this->faker->numberBetween(1, 100),
         'sprite_url' => $this->faker->imageUrl(),
         'pokedex_number' => $this->faker->unique()->numberBetween(1, 999),
         'evolves_from' => null, // puede ser seteado desde un seeder
      ];
   }
   ```

> ⚠️ No incluir `pokemon_token`, `is_active`, ni `timestamps`, ya que estos se generan automáticamente desde el modelo o base de datos.

---

## 🔗 Enlazar factory con el modelo

Agregá en el modelo:

   ```php
   public static function newFactory()
   {
      return \Database\Factories\PokemonFactory::new();
   }
   ```

---

## 💡 Estados personalizados

Podés definir variantes del factory para distintos contextos:

   ```php
   public function inactive()
   {
      return $this->state(fn () => ['is_active' => false]);
   }
   ```

---

## ✅ Buenas prácticas

- Nombrar los factories como `[NombreModelo]Factory`.
- En el modelo, agregar `newFactory()` para registrar su factory.
- Para datos realistas, personalizar `faker` con reglas útiles.

---

🔎 **Ejemplo real del proyecto:**  
- [`PokemonFactory.php`](./examples/databases/factories/PokemonFactory.php)
- [`PokemonModel`](./examples/app/Modules/Pokedex/Models/PokemonModel.php)