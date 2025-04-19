# 📥 Form Requests en Laravel

Los Form Requests permiten manejar validaciones de forma estructurada y reutilizable, desacoplando la lógica del controlador y centralizando reglas, mensajes y formatos personalizados.

---

> 🔗 [Volver al índice de configuración inicial](./index.md)
> 🔙 [Volver al paso anterior: Seeders con datos base](./seeders.md)
> ⏭️ [Ir al paso 15: Definición de rutas API (`api.php`)](./routes.md)

---

## 🧩 Convención: usar Save[Entidad]Request

En lugar de tener dos archivos (`StorePokemonRequest`, `UpdatePokemonRequest`), se recomienda usar un único `SavePokemonRequest` que cubra ambos casos (`store` y `update`), diferenciando el comportamiento según si el token está presente o no.

---

## 🛠️ Estructura recomendada

   ```bash
   php artisan make:request Modules/Pokedex/Requests/SavePokemonRequest
   ```

   ```php
   class SavePokemonRequest extends FormRequest
   {
      public function authorize(): bool
      {
         return true;
      }

      public function rules(): array
      {
         return array_merge(
            $this->rulesForName(),
            $this->rulesForLevel(),
            $this->rulesForSprite(),
            $this->rulesForPokedexNumber(),
            $this->rulesForEvolvesFrom(),
         );
      }
   ```

---

## 🧾 Definir rules por campo

Organizar reglas en métodos reutilizables mejora la legibilidad:

   ```php
   protected function rulesForName(): array
   {
      return [
         'name' => [
            'required',
            'string',
            'max:255',
         ],
      ];
   }

   protected function rulesForEvolvesFrom(): array
   {
      return [
         'evolves_from' => [
            'nullable',
            'string',
            'exists:pokemons,pokemon_token',
         ],
      ];
   }
   ```

---

## 🧠 Validar `unique` con excepción por token

   ```php
   protected function rulesForPokedex(): array
      {
         return [
            'pokedex_number' => [
               'required',
               'integer',
               'min:1',
               Rule::unique('pokemons', 'pokedex_number')->ignore($this->pokemon_token, 'pokemon_token'),
            ],
         ];
      }
   ```

---

## 🗣️ Definir mensajes personalizados

   ```php
   public function messages(): array
   {
      return [
         'name.required' => 'El :attribute es obligatorio.',
         'name.max' => 'El :attribute no puede superar los 255 caracteres.',
      ];
   }
   ```

---

## 🔤 Definir nombres personalizados para atributos

   ```php
   public function attributes(): array
   {
      return [
         'name' => 'nombre',
         'level' => 'nivel',
         'pokedex_number' => 'número de Pokédex',
      ];
   }
   ```

---

## 🔄 `prepareForValidation()`

Ideal para normalizar los datos antes de validar:

   ```php
   protected function prepareForValidation(): void
   {
      $this->merge([
         'pokedex_number' => (int) $this->pokedex_number,
         'name' => trim($this->name),
         'level' => (int) $this->level,
         'sprite_url' => trim($this->sprite_url),
      ]);
   }
   ```

---

## 🔁 `passedValidation()` para convertir tokens a IDs

   ```php
   protected function passedValidation(): void
      {
         $validatedData = parent::validated();

         // Convertir el token de evolución a ID
         if ($this->evolves_from) {
            $evolvesFromId = PokemonModel::query()
               ->where('pokemon_token', $this->evolves_from)
               ->where('is_active', true)
               ->value('pokemon_id');

            $validatedData['evolves_from'] = $evolvesFromId;
         } else {
            $validatedData['evolves_from'] = null;
         }

         // Almacenar los datos modificados
         $this->modifiedData = array_merge($this->validated(), $validatedData);
      }
   ```

---

## ✅ Reescribir `validated()` si necesitás devolver la data final procesada

   ```php
   public function validated($key = null, $default = null): array
   {
      return data_get($this->modifiedData ?: parent::validated(), $key, $default);
   }
   ```

---

🔎 **Ejemplo real del proyecto:**  
- [`SavePokemonRequest.php`](./examples/app/Modules/Pokedex/Requests/SavePokemonRequest.php)
- [`PokemonModel`](./examples/app/Modules/Pokedex/Models/PokemonModel.php)
