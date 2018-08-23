<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_ecommerce_id')->length(5)->unsigned();
            $table->string('name')->unique();
            $table->string('url')->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_ecommerce_id')->references('id')->on('user_ecommerce');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::table('shops', function (Blueprint $table) {
            Schema::dropIfExists('shops');
            Schema::dropForeign('shops_user_ecommerce_id_foreign');
        });
    }
}
