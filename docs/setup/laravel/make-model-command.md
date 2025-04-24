# 🧩 Comando Personalizado: make:model modular

Laravel, por defecto, genera los modelos en la carpeta `app/Models`. Para proyectos organizados por módulos, esto no es ideal. Este comando personalizado permite generar modelos en rutas como `app/Modules/...` de forma nativa.

---

> 📌 Este archivo forma parte del proceso de configuración inicial de comandos Artisan personalizados.  
> 🔗 [Volver al índice de configuración inicial](./index.md)  
> 🔙 [Volver al paso anterior: Configuración del entorno (.env)](./environment.md)  
> ⏭️ [Ir al paso 6: Comando personalizado: make:request modular](./make-request-command.md)

---

## 🎯 Objetivo

Permitir ejecutar:

   ```bash
   php artisan make:model Modules/Pokedex/Models/PokemonModel
   ```

Y que el archivo se genere en:

   ```
   app/Modules/Pokedex/Models/PokemonModel.php
   ```

En lugar de la ruta por defecto `app/Models`.

---

## ⚙️ Implementación

1. Ejecutar el comando para generar la clase personalizada:

   ```bash
   php artisan make:command ModelMakeCommand
   ```

2. Reemplazar su contenido por:

   ```php
   <?php

   namespace App\Console\Commands;

   use Illuminate\Foundation\Console\ModelMakeCommand as BaseCommand;

   class ModelMakeCommand extends BaseCommand
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
      \App\Console\Commands\ModelMakeCommand::class,
   ];
   ```

4. Si el archivo `Kernel.php` no existe, crearlo en `app/Console`.

---

## 🔎 Ejemplo real del proyecto

Podés ver el archivo implementado en el repositorio:

- [`ModelMakeCommand.php`](./examples/app/Console/Commands/ModelMakeCommand.php)
- [`Kernel.php`](./examples/app/Console/Kernel.php)  

Y el resultado en:

- [`PokemonModel.php`](./examples/app/Modules/Pokedex/Models/PokemonModel.php)
