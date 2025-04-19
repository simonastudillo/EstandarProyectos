# 🧭 Rutas API con apiResource

En esta guía se documenta cómo definir rutas limpias y estructuradas para una API REST usando `Route::apiResource`, ideal para controladores modulares.

---

> 🔗 [Volver al índice de configuración inicial](./index.md)
> 🔙 [Volver al paso anterior: Form Requests y validación personalizada](./requests.md)
> ⏭️ [Ir al paso 16: Controladores por módulo](./controllers.md)

---

## 📁 Archivo base: routes/api.php

Laravel usa este archivo para todas las rutas tipo API. Se carga automáticamente desde el `RouteServiceProvider`.

---

## 🚀 Crear rutas básicas con `apiResource`

   ```php
   use App\Modules\Pokedex\Controllers\PokedexController;
   use Illuminate\Support\Facades\Route;

   Route::apiResource('pokedex', PokedexController::class)
      ->parameters([
         'pokedex' => 'pokemon_token'
      ]);
   ```

Esto genera automáticamente las rutas estándar REST:

| Método | URI                   | Acción            |
|--------|------------------------|-------------------|
| GET    | /api/pokedex           | index()           |
| POST   | /api/pokedex           | store()           |
| GET    | /api/pokedex/{token}   | show()            |
| PUT    | /api/pokedex/{token}   | update()          |
| DELETE | /api/pokedex/{token}   | destroy()         |

---

## 🧩 Integración con RouteServiceProvider

Asegurate de tener este método en `app/Providers/RouteServiceProvider.php`:

   ```php
   protected function mapApiRoutes(): void
   {
      Route::prefix('api')
         ->middleware('api')
         ->group(base_path('routes/api.php'));
   }
   ```

Y registrar el provider en `bootstrap/providers.php`:

   ```php
   return [
      App\Providers\RouteServiceProvider::class,
   ];
   ```

---

## ✅ Buenas prácticas

- Usar `apiResource` siempre que sea posible.
- Personalizar nombres con `->names()` (opcional) para claridad en la documentación y trazabilidad.
- Utilizar `->parameters()` si usás tokens u otro campo personalizado en la URL.

---

🔎 **Ejemplo real del proyecto:**  
- [`api.php`](./examples/routes/api.php)
- [`RouteServiceProvider.php`](./examples/app/Providers/RouteServiceProvider.php)
- [`providers.php`](./examples/bootstrap/providers.php)
