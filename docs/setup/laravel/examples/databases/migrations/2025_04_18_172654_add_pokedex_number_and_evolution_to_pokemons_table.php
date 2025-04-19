<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
    * Run the migrations.
    */
   public function up()
   {
      Schema::table('pokemons', function (Blueprint $table) {
         $table->unsignedBigInteger('evolves_from')->nullable()->after('pokemon_id');
         $table->foreign('evolves_from', 'fk_pokemon_evolves_from')
            ->references('pokemon_id')
            ->on('pokemons')
            ->onDelete('set null')
            ->onUpdate('cascade');

         $table->integer('pokedex_number')->nullable()->after('evolves_from');
      });
   }

   public function down()
   {
      Schema::table('pokemons', function (Blueprint $table) {
         $table->dropForeign('fk_pokemon_evolves_from');
         $table->dropColumn(['pokedex_number', 'evolves_from']);
      });
   }
};
