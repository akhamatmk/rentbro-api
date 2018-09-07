<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogueCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogue_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('catalogue_id')->length(5)->unsigned()->nullable();
            $table->integer('category_id')->length(5)->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('catalogue_id')->references('id')->on('catalogues');
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
        Schema::dropIfExists('catalogue_category');
    }
}
