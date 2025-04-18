# 🧩 Comando Personalizado: make:request modular

Laravel genera los archivos `FormRequest` dentro de `app/Http/Requests` por defecto. Para una estructura modular, esto puede ser problemático. Este comando permite crear requests dentro de cualquier subcarpeta, como `app/Modules`.

---

> 📌 Este archivo forma parte del proceso de configuración inicial de comandos Artisan personalizados.  
> 🔗 [Volver al índice de configuración inicial](./index.md)
> 🔙 [Volver al paso anterior: Comando personalizado: make:model modular](./make-model-command.md)
> ⏭️ [Ir al paso 7: Comando personalizado: make:controller modular](./make-controller-command.md)

---

## 🎯 Objetivo

Permitir ejecutar:

   ```bash
   php artisan make:request Modules/Pokedex/Requests/SavePokemonRequest
   ```

Y que el archivo se cree en:

   ```
   app/Modules/Pokedex/Requests/SavePokemonRequest.php
   ```

---

## ⚙️ Implementación

1. Ejecutar el comando para generar la clase:

   ```bash
   php artisan make:command RequestMakeCommand
   ```

2. Modificar su contenido para extender el comando original:

   ```php
   <?php

   namespace App\Console\Commands;

   use Illuminate\Foundation\Console\RequestMakeCommand as BaseCommand;

   class RequestMakeCommand extends BaseCommand
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
      \App\Console\Commands\RequestMakeCommand::class,
   ];
   ```

---

## 📄 Resultado esperado

Al ejecutar el comando, se genera el archivo en la ruta exacta indicada, sin necesidad de moverlo desde `app/Http`.

---

## 🔎 Ejemplo real del proyecto

Implementación del comando:

- [`RequestMakeCommand.php`](./examples/app/Console/Commands/RequestMakeCommand.php)
- [`Kernel.php`](./examples/app/Console/Kernel.php)

Request generado:

- [`SavePokemonRequest.php`](./examples/app/Modules/Pokedex/Requests/SavePokemonRequest.php)
