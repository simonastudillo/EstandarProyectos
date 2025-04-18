# 🚦 Configurar el RouteServiceProvider

Laravel utiliza el `RouteServiceProvider` para registrar archivos de rutas. En proyectos mínimos o personalizados, este archivo no siempre está presente, por lo que se recomienda crearlo manualmente y registrarlo para que funcione correctamente el archivo `routes/api.php`.

---

> 🔗 [Volver al índice de configuración inicial](./index.md)
> 🔙 [Volver al paso anterior: Comando personalizado: make:controller modular](./make-controller-command.md)
> ⏭️ [Ir al paso 9: Migraciones y estructura de tablas](./migrations.md)

---

## 📁 Ubicación del archivo

   ```
   app/Providers/RouteServiceProvider.php
   ```

---

## 📄 Contenido base recomendado

   ```php
   <?php

   namespace App\Providers;

   use Illuminate\Support\Facades\Route;
   use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

   class RouteServiceProvider extends ServiceProvider
   {
      public function boot(): void
      {
         $this->mapApiRoutes();
         $this->mapWebRoutes();
      }

      protected function mapApiRoutes(): void
      {
         Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
      }

      protected function mapWebRoutes(): void
      {
         Route::middleware('web')
            ->group(base_path('routes/web.php'));
      }
   }
   ```

---

## 🧩 Registrar el provider

Si tu proyecto utiliza `bootstrap/providers.php`, registrá allí el provider:

   ```php
   return [
      // otros providers...
      App\Providers\RouteServiceProvider::class,
   ];
   ```

Esto reemplaza el comportamiento tradicional de `config/app.php`.

---

## 🔎 Ejemplo real del proyecto

Implementación del archivo:

- [`RouteServiceProvider.php`](./examples/app/Providers/RouteServiceProvider.php)
- [`providers.php`](./examples/bootstrap/providers.php)
- [api.php](./examples/routes/api.php)
