<?php

namespace App\Modules\Pokedex\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Pokedex\Models\PokemonModel;
use App\Modules\Pokedex\Requests\SavePokemonRequest;
use Illuminate\Http\JsonResponse;

class PokedexController extends Controller
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
