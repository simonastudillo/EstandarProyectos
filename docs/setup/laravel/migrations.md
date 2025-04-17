# 🧱 Migraciones y Estructura de Tablas en Laravel

En esta guía se documenta cómo crear y modificar tablas en Laravel mediante migraciones. Es el primer paso recomendado antes de desarrollar funcionalidades que dependan de la base de datos.

---

## 🆕 Crear una nueva migración

Para crear una tabla desde Artisan:

```bash
php artisan make:migration create_categories_table
```

---

## ✏️ Modificar tablas existentes

Para agregar columnas o índices a una tabla ya creada:

```bash
php artisan make:migration add_avatar_to_users_table
```

Esto genera un archivo con métodos `up()` y `down()`:

### ➕ Ejemplo para agregar columnas:

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('avatar')->nullable();
});
```

### 🔑 Ejemplo para agregar índices:

```php
Schema::table('users', function (Blueprint $table) {
    $table->index('email');
    $table->unique('username');
    $table->foreign('role_id')->references('role_id')->on('roles');
});
```

En el método `down()` se deben revertir los cambios:

```php
Schema::table('users', function (Blueprint $table) {
    $table->dropColumn('avatar');
    $table->dropIndex(['email']);
    $table->dropUnique(['username']);
    $table->dropForeign(['role_id']);
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

### Revertir la última migración ejecutada:

```bash
php artisan migrate:rollback
```

### Refrescar la base de datos (elimina y recrea lo existente):

```bash
php artisan migrate:refresh
```

> ⚠️ Este comando elimina tablas y datos. **No usar en producción.**

### Eliminar todas las tablas y recrear desde cero:

```bash
php artisan migrate:fresh
```

> ⚠️ Elimina absolutamente todas las tablas. **No usar en producción.**

---

## 🧠 Buenas prácticas

- Cada migración debe representar un cambio único y claro.
- Usa nombres descriptivos para las migraciones.
- Evita mezclar múltiples tipos de cambios en una sola migración.
- Documenta las relaciones entre tablas en los modelos correspondientes (`hasOne`, `belongsTo`, etc.).

---

## 🧪 Ejemplo completo de migración con convención personalizada

A continuación, se muestra un ejemplo recomendado según este estándar. Se prioriza:

- Uso de identificadores personalizados (`post_id`, `user_id`, etc.)
- Orden lógico: ID → claves foráneas → datos → tokens/control → estados → fechas
- Legibilidad y rendimiento
- Nombres explícitos en claves foráneas

```php
Schema::create('posts', function (Blueprint $table) {
    // ID principal con nombre específico
    $table->id('post_id');

    // Foreign key (usuario que creó el post)
    $table->unsignedBigInteger('created_by')->nullable()->index();
    $table->foreign('created_by', 'fk_users_post_created_by')
        ->references('user_id')
        ->on('users')
        ->onDelete('set null')
        ->onUpdate('cascade');

    // Campos de datos
    $table->string('title')->notNullable();
    $table->longText('content')->notNullable();

    // Token de edición o URL segura
    $table->string('post_token')->nullable()->unique()->index();

    // Estado activo (más rápido que usar deleted_at)
    $table->boolean('is_active')->default(true)->index();

    // Fechas
    $table->timestamp('created_at')->useCurrent();
    $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
    $table->softDeletes()->nullable();
});
```

> 📌 Este estilo puede implicar definir relaciones de forma más explícita en los modelos, pero mejora la claridad en bases de datos complejas y facilita los mantenimientos a largo plazo.
