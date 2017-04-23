<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('code');
            $table->tinyInteger('severity')->nullable();

            $table->string('error', 2000);
            $table->integer('user_id')->nullable();
            $table->string('route')->nullable();
            $table->string('method', 20)->nullable();
            $table->string('url', 1000)->nullable();
            $table->string('session')->nullable();
            $table->string('referer', 1000)->nullable();

            $table->string('file', 1000)->nullable();
            $table->integer('row')->nullable();
            $table->text('trace')->nullable();
            $table->string('exception', 500)->nullable();
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
        Schema::dropIfExists('logs');
    }
}
