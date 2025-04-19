# 🧩 Comando Personalizado: make:controller modular

Laravel crea controladores por defecto dentro de `app/Http/Controllers`. En un proyecto modular esto no es conveniente. Este comando personalizado permite crear controladores dentro de cualquier módulo o carpeta personalizada.

---

> 📌 Este archivo forma parte del proceso de configuración inicial de comandos Artisan personalizados.  
> 🔗 [Volver al índice de configuración inicial](./index.md)
> 🔙 [Volver al paso anterior: Comando personalizado: make:request modular](./make-request-command.md)
> ⏭️ [Ir al paso 8: Configuración del RouteServiceProvider](./route-provider.md)

---

## 🎯 Objetivo

Permitir ejecutar:

   ```bash
   php artisan make:controller Modules/Pokedex/Controllers/PokemonController
   ```

Y que el archivo se genere en:

   ```
   app/Modules/Pokedex/Controllers/PokemonController.php
   ```

---

## ⚙️ Implementación

1. Ejecutar el comando Artisan:

   ```bash
   php artisan make:command ControllerMakeCommand
   ```

2. Reemplazar el contenido generado por:

   ```php
   <?php

   namespace App\Console\Commands;

   use Illuminate\Routing\Console\ControllerMakeCommand as BaseCommand;

   class ControllerMakeCommand extends BaseCommand
   {
      protected function getDefaultNamespace($rootNamespace)
      {
         return $rootNamespace;
      }
   }
   ```

3. Registrar el comando en `app/Console/Kernel.php`:

   ```php
   protected $commands = [
      \App\Console\Commands\ControllerMakeCommand::class,
   ];
   ```

---

## 📄 Resultado esperado

El controlador será generado directamente en la ubicación especificada, sin ser forzado a `app/Http/Controllers`.

---

## 🔎 Ejemplo real del proyecto

Implementación del comando:

- [`ControllerMakeCommand.php`](./examples/app/Console/Commands/ControllerMakeCommand.php)
- [`Kernel.php`](./examples/app/Console/Kernel.php)

Controlador generado:

- [`PokemonController.php`](./examples/app/Modules/Pokedex/Controllers/PokedexController.php)
