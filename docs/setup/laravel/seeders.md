# 🌱 Seeders en Laravel

Los seeders permiten poblar la base de datos con datos iniciales o de prueba. Se suelen usar junto con factories para generar contenido realista durante el desarrollo.

---

> 🔗 [Volver al índice de configuración inicial](./index.md)  
> 🔙 [Volver al paso anterior: Factories y generación de datos](./factories.md)  
> ⏭️ [Ir al paso 14: Form Requests y validación personalizada](./requests.md)

---

## 🛠️ Crear un seeder

   ```bash
   php artisan make:seeder PokemonSeeder
   ```

Esto crea el archivo en:

   ```
   database/seeders/PokemonSeeder.php
   ```

---

## 📄 Estructura recomendada

   ```php
   use App\Modules\Pokedex\Models\PokemonModel;

   public function run()
   {
      PokemonModel::factory()->count(10)->create();
   }
   ```

> 💡 Para datos fijos o iniciales (como un pokémon específico), podés usar `insert()` manual o crear instancias con `create()`.

---

## 🧩 Agregar el seeder a DatabaseSeeder

Editá el archivo `database/seeders/DatabaseSeeder.php` y dentro del método `run()`, asegurate de llamar al seeder:

   ```php
   public function run()
   {
      $this->call([
         PokemonSeeder::class,
      ]);
   }
   ```

Esto permite que al ejecutar `php artisan db:seed`, Laravel ejecute también `PokemonSeeder`.

---

## 📦 Ejecutar seeders

- Para ejecutar **todos** los seeders registrados en `DatabaseSeeder.php`:

   ```bash
   php artisan db:seed
   ```

- Para ejecutar un seeder específico:

   ```bash
   php artisan db:seed --class=PokemonSeeder
   ```

---

## 🎯 Buenas prácticas

- Crear un seeder por cada tabla (por ejemplo: `PokemonSeeder`, `UserSeeder`, etc.).
- Si tenés relaciones entre modelos, respetá el orden de inserción.
- No incluir datos sensibles o de producción.
- Usá nombres explícitos y factories cuando sea posible.

---

🔎 **Ejemplo real del proyecto:**  
- [`PokemonSeeder.php`](./examples/databases/seeders/PokemonSeeder.php)
- [`DatabaseSeeder.php`](./examples/databases/seeders/DatabaseSeeder.php)
