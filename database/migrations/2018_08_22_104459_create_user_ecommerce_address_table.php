<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEcommerceAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ecommerce_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_ecommerce_id')->length(5)->unsigned()->nullable();
            $table->integer('province_id')->length(5)->unsigned()->nullable();
            $table->integer('regency_id')->length(5)->unsigned()->nullable();
            $table->integer('district_id')->length(5)->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->text('full_address')->nullable();
            $table->boolean('primary')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_ecommerce_id')->references('id')->on('user_ecommerce');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('regency_id')->references('id')->on('regencies');
            $table->foreign('district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_ecommerce_address');
    }
}
