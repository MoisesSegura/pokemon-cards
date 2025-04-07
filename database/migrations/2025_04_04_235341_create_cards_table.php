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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('api_id')->unique(); // id original de la API
            $table->string('name');
            $table->string('supertype')->nullable();
            $table->json('subtypes')->nullable();
            $table->string('hp')->nullable();
            $table->json('types')->nullable();
            $table->string('evolves_from')->nullable();
            $table->json('abilities')->nullable();
            $table->json('attacks')->nullable();
            $table->json('weaknesses')->nullable();
            $table->json('retreat_cost')->nullable();
            $table->string('set_name')->nullable();
            $table->string('rarity')->nullable();
            $table->string('artist')->nullable();
            $table->text('flavor_text')->nullable();
            $table->string('image_url')->nullable();
            $table->string('tcgplayer_url')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
