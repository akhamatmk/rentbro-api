<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id')->length(5)->unsigned()->nullable();
            $table->integer('district_id')->length(5)->unsigned()->nullable();
            $table->string('alias_name')->nullable();            
            $table->string('zip_code')->nullable();
            $table->text('detail_location')->nullable();
            $table->string('fax')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('status')->default(1)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vendor_id')->references('id')->on('vendors');
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
        Schema::table('vendor_locations', function (Blueprint $table) {
            Schema::dropIfExists('vendor_locations');
            Schema::dropForeign('vendor_locations_vendor_id_foreign');
            Schema::dropForeign('vendor_locations_district_id_foreign');
        });
    }
}
