<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
    * Run the migrations.
    */
   public function up(): void
   {
      Schema::create('pokemons', function (Blueprint $table) {
         $table->id('pokemon_id');

         $table->string('name')->notNullable();
         $table->integer('level')->default(1);
         $table->string('sprite_url')->nullable();

         $table->string('pokemon_token')->nullable()->unique()->index();
         $table->boolean('is_active')->default(true)->index();

         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
         $table->softDeletes()->nullable();
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::dropIfExists('pokemons');
   }
};
