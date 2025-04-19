# 🧱 Migraciones y Estructura de Tablas en Laravel

En esta guía se documenta cómo crear y modificar tablas en Laravel mediante migraciones. Es el primer paso recomendado antes de desarrollar funcionalidades que dependan de la base de datos.

---

> 🔗 [Volver al índice de configuración inicial](./index.md)  
> 🔙 [Volver al paso anterior: Configuración del RouteServiceProvider](./route-provider.md)  
> ⏭️ [Ir al paso 10: Modelos y relaciones](./models.md)

---

## 🆕 Crear una nueva migración

Para crear una tabla desde Artisan:

   ```bash
   php artisan make:migration create_pokemons_table
   ```

---

## ✏️ Modificar tablas existentes

Para agregar columnas o índices a una tabla ya creada:

   ```bash
   php artisan make:migration add_pokedex_number_and_evolution_to_pokemons_table
   ```

Esto genera un archivo con métodos `up()` y `down()`:

### Estructura recomendada:

   ```php
   Schema::table('pokemons', function (Blueprint $table) {
      $table->integer('pokedex_number')->nullable()->after('level');
      $table->unsignedBigInteger('evolves_from')->nullable()->after('pokedex_number');

      $table->foreign('evolves_from', 'fk_pokemon_evolution')
         ->references('pokemon_id')
         ->on('pokemons')
         ->onDelete('set null')
         ->onUpdate('cascade');
   });
   ```

Y en el método `down()`:

   ```php
   Schema::table('pokemons', function (Blueprint $table) {
      $table->dropForeign('fk_pokemon_evolution');
      $table->dropColumn(['pokedex_number', 'evolves_from']);
   });
   ```
---

## 🚀 Ejecutar migraciones

Para aplicar todas las migraciones pendientes:

   ```bash
   php artisan migrate
   ```

---

## ♻️ Comandos útiles

   ```bash
   php artisan migrate:rollback    # Revierte la última migración
   php artisan migrate:refresh     # Elimina y vuelve a ejecutar migraciones
   php artisan migrate:fresh       # Elimina todas las tablas y vuelve a migrar
   ```

> ⚠️ Evitá `refresh` y `fresh` en producción.

---

## 🧠 Buenas prácticas

- Una migración por cambio lógico (agregar columnas relacionadas entre sí → una sola migración).
- Nombrar claves foráneas con prefijos únicos (`fk_modulo_tabla_campo`) para facilitar mantenimiento.
- Siempre definir el `down()` para revertir el cambio de forma segura.
- Uso de identificadores personalizados (`post_id`, `user_id`, etc.)
- Orden lógico: ID → claves foráneas → datos → tokens/control → estados → fechas
- Legibilidad y rendimiento
- Nombres explícitos en claves foráneas

---

> 📌 Este estilo puede implicar definir relaciones de forma más explícita en los modelos, pero mejora la claridad en bases de datos complejas y facilita los mantenimientos a largo plazo.

---

## 🔎 Ejemplo real del proyecto
- [`2024_04_15_000001_create_pokemons_table.php`](./examples/databases/migrations/2025_04_18_014433_create_pokemons_table.php)
- [`2025_04_18_172654_add_pokedex_number_and_evolution_to_pokemons_table.php`](./examples/databases/migrations/2025_04_18_172654_add_pokedex_number_and_evolution_to_pokemons_table.php)
