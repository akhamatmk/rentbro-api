<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->length(5)->unsigned()->nullable();
            $table->string('name');
            $table->boolean('type')->default(1);
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('province_id')->references('id')->on('provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regencies', function (Blueprint $table) {
            Schema::dropIfExists('regencies');
            // Schema::dropForeign('regencies_user_province_id_foreign');
        });
    }
}
