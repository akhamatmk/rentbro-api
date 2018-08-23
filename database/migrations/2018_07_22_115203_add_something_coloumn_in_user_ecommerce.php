<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomethingColoumnInUserEcommerce extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_ecommerce', function (Blueprint $table) {
            $table->string('image')->default('https://res.cloudinary.com/kodami/image/upload/v1528252426/user_kjwzkq.png')->nullable();
            $table->date('birth_day')->default(date("Y-m-d"))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_ecommerce', function (Blueprint $table) {
            //
        });
    }
}
