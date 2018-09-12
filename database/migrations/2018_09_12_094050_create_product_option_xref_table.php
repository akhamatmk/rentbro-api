<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOptionXrefTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_option_xref', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_option_id')->length(5)->unsigned();
            $table->integer('product_option_value_id')->length(5)->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_option_id')->references('id')->on('product_options');
            $table->foreign('product_option_value_id')->references('id')->on('product_option_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_option_xref');
    }
}
