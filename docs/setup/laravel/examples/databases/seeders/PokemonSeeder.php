<?php

namespace Database\Seeders;

use App\Modules\Pokedex\Models\PokemonModel;
use Illuminate\Database\Seeder;

class PokemonSeeder extends Seeder
{
   /**
    * Run the database seeds.
    */
   public function run(): void
   {
      PokemonModel::factory()
         ->count(10) // Cambia el número de registros a crear
         ->create();
   }
}
