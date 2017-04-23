<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_sales', function (Blueprint $table) {
            $table->string('guid');
            $table->integer('item_id')->nullable();
            $table->integer('external_id');


            /** For mapping sale to item */
            $table->integer('link_id');
            $table->integer('level');
            $table->integer('championLevel');
            $table->integer('quality');
            $table->integer('trait');
            $table->integer('itemLink_last');


            $table->integer('guild_id')->nullable();
            $table->string('item_key');
            $table->integer('price');
            $table->integer('price_ea');
            $table->integer('quantity')->default(1);
            $table->string('seller');
            $table->string('buyer');
            $table->string('itemLink');
            $table->boolean('isKiosk')->default(false);
            $table->dateTime('sold_at');
            $table->timestamps();

            $table->primary('guid');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_sales');
    }
}
