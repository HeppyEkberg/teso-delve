<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbilityCharacterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ability_character', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('character_id');
            $table->integer('ability_id');
            $table->integer('rank');
            $table->integer('morphRank')->nullable();
            $table->integer('progression');
            $table->integer('skillpoints');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ability_character');
    }
}
