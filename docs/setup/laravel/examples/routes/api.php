<?php

use App\Modules\Pokedex\Controllers\PokedexController;
use Illuminate\Support\Facades\Route;

Route::apiResource('pokedex', PokedexController::class)
   ->parameters([
      'pokedex' => 'pokemon_token'
   ]);
