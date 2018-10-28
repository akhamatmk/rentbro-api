<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreteTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('user_ecommerce_id')->length(5)->unsigned()->nullable();
            $table->string('code_trans')->unique();
            $table->integer('shipping')->default(0);
            $table->integer('price')->default(0);

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
        //
    }
}
