<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->length(5)->unsigned()->nullable();
            $table->integer('item_id')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_image')->nullable();
            $table->string('price_item')->nullable();
            $table->string('place_id')->nullable();
            $table->string('courier')->nullable();
            $table->integer('shipping')->nullable();
            $table->integer('price')->nullable();
            $table->text('full_address')->nullable();
            $table->text('time_rent')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_transactions');
    }
}
