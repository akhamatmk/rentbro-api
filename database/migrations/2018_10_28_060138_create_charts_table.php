<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->length(5)->unsigned()->nullable();
            $table->integer('place_id')->length(5)->unsigned()->nullable();
            $table->integer('user_ecommerce_id')->length(5)->unsigned()->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('valid_until')->nullable();

            $table->timestamps();
            $table->foreign('user_ecommerce_id')->references('id')->on('user_ecommerce');
            $table->foreign('place_id')->references('id')->on('user_ecommerce_address');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charts');
    }
}
