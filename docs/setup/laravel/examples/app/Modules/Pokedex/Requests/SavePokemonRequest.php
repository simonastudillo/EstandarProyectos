<?php

namespace App\Modules\Pokedex\Requests;

use App\Modules\Pokedex\Models\PokemonModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SavePokemonRequest extends FormRequest
{
   protected array $modifiedData = [];
   /**
    * Determine if the user is authorized to make this request.
    */
   public function authorize(): bool
   {
      return true;
   }

   /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */
   public function rules(): array
   {
      return array_merge(
         $this->rulesForEvolvesFrom(),
         $this->rulesForPokedex(),
         $this->rulesForName(),
         $this->rulesForLevel(),
         $this->rulesForSpriteUrl()
      );
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

   protected function rulesForLevel(): array
   {
      return [
         'level' => [
            'required',
            'integer',
            'min:1',
            'max:100',
         ],
      ];
   }

   protected function rulesForSpriteUrl(): array
   {
      return [
         'sprite_url' => [
            'required',
            'url',
            'max:255',
         ],
      ];
   }


   public function messages(): array
   {
      return [
         'evolves_from.string' => 'El campo :attribute debe ser una cadena de texto.',
         'evolves_from.exists' => 'El campo :attribute no existe como token de un pokémon.',
         'evolves_from.max' => 'El campo :attribute no puede tener más de 255 caracteres.',

         'pokedex_number.required' => 'El :attribute es obligatorio.',
         'pokedex_number.integer' => 'El :attribute debe ser un número entero.',
         'pokedex_number.unique' => 'El :attribute ya existe.',
         'pokedex_number.min' => 'El :attribute debe ser al menos 1.',

         'name.required' => 'El :attribute es obligatorio.',
         'name.string' => 'El :attribute debe ser una cadena de texto.',
         'name.max' => 'El :attribute no puede tener más de 255 caracteres.',

         'level.required' => 'El :attribute es obligatorio.',
         'level.integer' => 'El :attribute debe ser un número entero.',
         'level.min' => 'El :attribute debe ser al menos 1.',
         'level.max' => 'El :attribute no puede ser mayor a 100.',

         'sprite_url.required' => 'La :attribute de la imagen es obligatoria.',
         'sprite_url.url' => 'La :attribute de la imagen debe ser válida.',
         'sprite_url.max' => 'La :attribute de la imagen no puede tener más de 255 caracteres.',
      ];
   }

   public function attributes(): array
   {
      return [
         'pokedex_number' => 'número de Pokédex',
         'evolves_from' => 'evoluciona de',
         'name' => 'nombre',
         'level' => 'nivel',
         'sprite_url' => 'URL',
      ];
   }

   protected function prepareForValidation(): void
   {
      $this->merge([
         'pokedex_number' => (int) $this->pokedex_number,
         'name' => trim($this->name),
         'level' => (int) $this->level,
         'sprite_url' => trim($this->sprite_url),
      ]);
   }

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

   public function validated($key = null, $default = null): array
   {
      return data_get($this->modifiedData ?: parent::validated(), $key, $default);
   }
}
