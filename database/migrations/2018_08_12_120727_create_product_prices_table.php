<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->length(5)->unsigned()->nullable();
            $table->integer('type')->default(1);
            $table->integer('amount')->default(1);
            $table->integer('price')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::table('product_prices', function (Blueprint $table) {
            Schema::dropIfExists('product_prices');
            Schema::dropForeign('product_prices_product_id_foreign');
        });
    }
}
