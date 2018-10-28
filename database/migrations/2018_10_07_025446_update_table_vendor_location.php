<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableVendorLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_locations', function (Blueprint $table) {
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latlatitude', 10, 7)->nullable();
            $table->string('map_street')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_locations', function (Blueprint $table) {
            //
        });
    }
}
