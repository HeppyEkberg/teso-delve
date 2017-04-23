<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLangToAbilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abilities', function (Blueprint $table) {
            $table->string('lang')->default('en')->after('isUltimate');
            $table->string('externalName')->after('name')->nullable();
        });

        Schema::table('skill_lines', function (Blueprint $table) {
            $table->string('lang')->default('en')->after('skilltypeEnum');
            $table->string('externalName')->after('name')->nullable();
        });

        $skillLines = \App\Model\SkillLine::whereNull('externalName')->get();
        foreach($skillLines as $skillLine) {
            $skillLine->externalName = $skillLine->name;
            $skillLine->save();
        }

        $abilities = \App\Model\Ability::whereNull('externalName')->get();
        foreach($abilities as $ability) {
            $ability->externalName = $ability->name;
            $ability->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abilities', function (Blueprint $table) {
            $table->dropColumn(['lang', 'externalName']);
        });

        Schema::table('skill_lines', function (Blueprint $table) {
            $table->dropColumn(['lang', 'externalName']);
        });
    }
}
