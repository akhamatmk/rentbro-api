<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterWithOtherAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_with_other_apps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_ecommerce_id')->length(5)->unsigned()->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

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
        Schema::table('register_with_other_apps', function (Blueprint $table) {
            Schema::dropIfExists('register_with_other_apps');
            Schema::dropForeign('register_with_other_apps_user_ecommerce_id_foreign');
        });
    }
}
