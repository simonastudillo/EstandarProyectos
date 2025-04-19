<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PokemonFactory extends Factory
{

   protected $model = \App\Modules\Pokedex\Models\PokemonModel::class;
   /**
    * Define the model's default state.
    *
    * @return array<string, mixed>
    */
   public function definition(): array
   {
      return [
         'pokedex_number' => $this->faker->unique()->numberBetween(1, 1000),
         'name' => $this->faker->word(),
         'level' => $this->faker->numberBetween(1, 100),
         'sprite_url' => $this->faker->imageUrl(),
      ];
   }
}
