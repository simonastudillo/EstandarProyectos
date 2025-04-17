# 🌱 Seeders y Factories en Laravel

Esta guía detalla cómo definir datos por defecto del sistema mediante **seeders** y **factories**, siguiendo convenciones consistentes para facilitar pruebas y desarrollo.

---

## 🌾 Seeders

### 📌 ¿Qué es un seeder?

Un *seeder* permite insertar datos por defecto en la base de datos, útil para llenar catálogos, roles, configuraciones iniciales, etc.

### 🛠️ Crear un seeder

```bash
php artisan make:seeder UserSeeder
```

El archivo se crea en `database/seeders/`.

### ✏️ Usar el seeder

Edita el método `run()`:

```php
public function run()
{
    DB::table('users')->insert([
        'user_id' => 1,
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('admin123'),
        'is_active' => true,
    ]);
}
```

> 🧠 Usa `user_id` en vez de `id` si sigues la convención personalizada.

### 🚀 Ejecutar los seeders

```bash
php artisan db:seed
```

O uno específico:

```bash
php artisan db:seed --class=UserSeeder
```

---

## 🧪 Factories

### 📌 ¿Qué es un factory?

Un *factory* genera datos aleatorios para pruebas o desarrollo. Ideal para generar muchos registros con estructura consistente.

### 🛠️ Crear un factory

```bash
php artisan make:factory PostFactory
```

El archivo se crea en `database/factories/`.

### 🧬 Estructura base

```php
use Illuminate\Support\Str;

protected $model = \App\Modules\Post\Models\PostModel::class;

public function definition()
{
    return [
        'title' => $this->faker->sentence(),
        'content' => $this->faker->paragraph(3),
        'post_token' => hash('sha256', Str::uuid()),
        'created_by' => 1,
        'is_active' => true,
    ];
}
```

### 🔗 Enlazar factory con el modelo

```php
public static function newFactory()
{
    return \Database\Factories\PostFactory::new();
}
```

### 🚀 Usar un factory desde un seeder

```php
PostModel::factory()->count(10)->create();
```

---

## ✅ Buenas prácticas

- Crear un seeder por cada tabla del sistema.
- Nombrar los factories como `[NombreModelo]Factory`.
- En el modelo, agregar `newFactory()` para registrar su factory.
- Para datos realistas, personalizar `faker` con reglas útiles.
