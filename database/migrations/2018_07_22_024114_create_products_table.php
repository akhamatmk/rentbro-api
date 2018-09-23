<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->length(5)->unsigned();
            $table->integer('category_id')->length(5)->unsigned();
            $table->string('name');
            $table->string('alias');
            $table->integer('kind_of_rent');
            $table->integer('quantity');
            $table->integer('price');
            $table->double('weight')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('category_id')->references('id')->on('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            Schema::dropIfExists('products');
            Schema::dropForeign('products_shop_id_foreign');
            Schema::dropForeign('products_category_id_foreign');
        });
    }
}
