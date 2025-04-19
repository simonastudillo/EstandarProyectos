# 🧩 Controladores por Módulo

Esta guía explica cómo organizar controladores dentro de una estructura modular, usando convenciones claras, requests personalizados y recursos de respuesta si aplica.

---

> 🔗 [Volver al índice de configuración inicial](./index.md)
> 🔙 [Volver al paso anterior: Definición de rutas API (`api.php`)](./routes.md)

---

## 📁 Estructura modular recomendada

   ```bash
   php artisan make:controller Modules/Pokedex/Controllers/PokemonController
   ```

Esto genera:

   ```
   app/Modules/Pokedex/Controllers/PokemonController.php
   ```

---

## 🧩 Patrón recomendado

Los métodos estándar de un controlador de API deben cubrir:

- `index()` → listar recursos
- `store()` → crear nuevo recurso
- `show()` → mostrar recurso único
- `update()` → actualizar recurso
- `destroy()` → eliminar recurso

---

## 🧾 Ejemplo base de controlador

   ```php
   use App\Http\Controllers\Controller;
   use App\Modules\Pokedex\Models\PokemonModel;
   use App\Modules\Pokedex\Requests\SavePokemonRequest;
   use Illuminate\Http\JsonResponse;

   class PokemonController extends Controller
   {
      public function index(): JsonResponse
      {
         $posts = PokemonModel::with('evolutions')
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->paginate(5);
         return response()->json([
            'message' => 'List of Pokémon',
            'data' => $posts
         ]);
      }

      public function store(SavePokemonRequest $request)
      {
         $pokemon = PokemonModel::create($request->validated());
         return response()->json([
            'message' => 'Pokémon created successfully',
            'data' => $pokemon
         ]);
      }

      public function show(string $pokemon_token): JsonResponse
      {
         $pokemon = PokemonModel::where('pokemon_token', $pokemon_token)->first();
         if (!$pokemon) {
            return response()->json([
               'message' => 'Pokémon not found'
            ], 404);
         }
         return response()->json([
            'message' => 'Pokémon details',
            'data' => $pokemon
         ]);
      }

      public function update(SavePokemonRequest $request, string $pokemon_token): JsonResponse
      {
         $pokemon = PokemonModel::where('pokemon_token', $pokemon_token)->first();
         if (!$pokemon) {
            return response()->json([
               'message' => 'Pokémon not found'
            ], 404);
         }
         $pokemon->update($request->validated());
         return response()->json([
            'message' => 'Pokémon updated successfully',
            'data' => $pokemon
         ]);
      }

      public function destroy(string $pokemon_token): JsonResponse
      {
         $pokemon = PokemonModel::where('pokemon_token', $pokemon_token)->first();
         if (!$pokemon) {
            return response()->json([
               'message' => 'Pokémon not found'
            ], 404);
         }
         $pokemon->delete();
         return response()->json([
            'message' => 'Pokémon deleted successfully',
            'data' => $pokemon
         ]);
      }
   }
   ```

---

## ✅ Buenas prácticas

- Usar `FormRequest` para store/update (`SavePokemonRequest`)
- Inyectar modelos usando route model binding
- Aplicar `with('relación')` para evitar N+1
- Usar nombres claros, acordes a `apiResource`

---

🔎 **Ejemplo real del proyecto:**  
- [`PokemonController.php`](./examples/app/Modules/Pokedex/Controllers/PokedexController.php)
- [`SavePokemonRequest`](./examples/app/Modules/Pokedex/Requests/SavePokemonRequest.php)
- [`PokemonModel`](./examples/app/Modules/Pokedex/Models/PokemonModel.php)
