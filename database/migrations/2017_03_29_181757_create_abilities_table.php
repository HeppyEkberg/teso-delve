<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('skill_line_id');
            $table->integer('parent_id')->nullable();
            $table->integer('index');
            $table->tinyInteger('morph')->nullable();
            $table->string('name');
            $table->string('image');
            $table->string('description', 500);

            $table->integer('minRange')->nullable();
            $table->integer('maxRange')->nullable();
            $table->integer('maxSkillpoints')->nullable();
            $table->integer('radius')->nullable();
            $table->integer('angle')->nullable();
            $table->string('target')->nullable();
            $table->integer('cost')->nullable();
            $table->tinyInteger('powertypeEnum')->nullable();
            $table->integer('duration')->nullable();

            $table->integer('castTime')->nullable();
            $table->integer('channelTime')->nullable();

            $table->boolean('isTank')->default(false);
            $table->boolean('isHealer')->default(false);
            $table->boolean('isDPS')->default(false);

            $table->string('baseName');
            $table->boolean('isChanneled');
            $table->boolean('isPassive');
            $table->boolean('isUltimate');
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
        Schema::dropIfExists('abilities');
    }
}
