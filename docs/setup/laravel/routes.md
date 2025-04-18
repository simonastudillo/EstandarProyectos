# 🧭 Rutas con `resource` y `apiResource` en Laravel

Esta guía explica cómo definir rutas RESTful en Laravel utilizando `Route::resource` y `Route::apiResource`, con ejemplos prácticos y convenciones recomendadas.

---

## 📌 ¿Cuándo usar resource vs apiResource?

| Método             | Incluye rutas para | Uso recomendado |
|--------------------|--------------------|-----------------|
| `Route::resource`  | Web y vistas (`create`, `edit`) | Aplicaciones con frontend Blade |
| `Route::apiResource` | Solo rutas API REST | Proyectos con APIs puras (ej. frontend separado) |

---

## 🛠️ Crear rutas automáticamente

```php
use App\Modules\Posts\Controller\PostsController;

// Solo para API (sin create/edit)
Route::apiResource('posts', PostsController::class);

// Para web (con create/edit)
Route::resource('posts', PostsController::class)
    ->parameters(['posts' => 'id']) // Define el nombre del parámetro de la ruta como 'id' en lugar de 'posts'
    ->names('posts'); // Cambia el nombre de las rutas de posts a posts.index, posts.show, etc.
```

---

## 🧭 Rutas generadas por `Route::resource`

| Método HTTP | Ruta                | Acción del controlador      |
|-------------|---------------------|-----------------------------|
| GET         | /posts              | index()                     |
| GET         | /posts/create       | create()                    |
| POST        | /posts              | store()                     |
| GET         | /posts/{id}         | show()                      |
| GET         | /posts/{id}/edit    | edit()                      |
| PUT/PATCH   | /posts/{id}         | update()                    |
| DELETE      | /posts/{id}         | destroy()                   |

---

## ✍️ Personalización recomendada

### ➕ Cambiar nombre del parámetro

```php
Route::resource('posts', PostsController::class)
    ->parameters(['posts' => 'post_id']);
```

Esto hará que `{post_id}` sea el nombre del parámetro en las rutas.

---

### 🏷️ Cambiar nombres de las rutas

```php
Route::resource('posts', PostsController::class)
    ->names([
        'index' => 'posts.list',
        'show' => 'posts.view',
    ]);
```

---

## ✅ Buenas prácticas

- Prefiere `apiResource` si estás construyendo una API moderna.
- Usa `->parameters()` si tu modelo no usa `id` como clave primaria.
- Centraliza tus rutas en archivos organizados (`routes/api.php`, `routes/web.php`).
- Aplica middleware de forma explícita para control de acceso.

---

## 🔐 Ejemplo con middleware y prefijo

```php
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('posts', PostController::class);
});
```
