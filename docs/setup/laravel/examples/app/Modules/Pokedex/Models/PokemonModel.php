<?php

namespace App\Modules\Pokedex\Models;

use App\Modules\Shared\Traits\SoftDeactivatesTrait;
use Database\Factories\PokemonFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PokemonModel extends Model
{

   use HasFactory, SoftDeletes, SoftDeactivatesTrait;

   protected $table = 'pokemons'; // nombre de tabla en la base de datos
   protected $primaryKey = 'pokemon_id'; // clave primaria de la tabla
   protected $fillable = ['evolves_from', 'pokedex_number', 'name', 'level', 'sprite_url']; // campos que se pueden llenar masivamente
   protected $guarded = ['pokemon_id', 'pokemon_token', 'is_active', 'created_at', 'updated_at', 'deleted_at']; // campos que no se pueden llenar masivamente

   protected static function booted()
   {
      static::creating(function ($pokemon) {
         $uuid = (string) Str::uuid();
         $pokemon->pokemon_token = hash('sha256', $uuid);
      });
   }

   protected static function newFactory(): PokemonFactory
   {
      return PokemonFactory::new(); //Factory a utilizar
   }


   public function getRouteKeyName(): string
   {
      return 'pokemon_token'; // nombre del token para las rutas
   }

   protected function casts(): array
   {
      return [
         'is_active' => 'boolean',
         'created_at' => 'datetime',
         'updated_at' => 'datetime',
         'deleted_at' => 'datetime'
      ];
   }

   protected function name(): Attribute
   {
      return Attribute::make(
         get: fn($value) => ucfirst($value),
         set: fn($value) => strtolower($value),
      );
   }

   // Obtiene el pokemon que evoluciona a este Pokémon
   public function evolvesFrom()
   {
      return $this->belongsTo(self::class, 'evolves_from', 'pokemon_id')
         ->where('is_active', true);
   }

   // Obtiene los Pokémons que puede evolucionar a este Pokémon
   public function evolutions()
   {
      return $this->hasMany(self::class, 'evolves_from', 'pokemon_id')
         ->where('is_active', true);
   }
}
