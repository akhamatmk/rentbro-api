<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_ecommerce_id')->length(5)->unsigned()->nullable();
            $table->string('nickname')->unique();
            $table->string('full_name');
            $table->string('motto')->nullable();
            $table->text('description');
            $table->text('logo')->nullable();
            $table->datetime('last online')->default(date('Y-m-d'))->nullable();
            $table->boolean('open_shop')->default(1)->nullable();
            $table->datetime('start_close')->nullable();
            $table->datetime('end_close')->nullable();
            $table->boolean('status')->default(1)->nullable();
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
        Schema::table('vendors', function (Blueprint $table) {
            Schema::dropIfExists('vendors');
            Schema::dropForeign('vendors_other_user_ecommerce_id_foreign');
        });
    }
}
