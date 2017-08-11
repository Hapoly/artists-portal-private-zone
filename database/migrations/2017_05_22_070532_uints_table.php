<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user');
            $table->string('title');
            $table->string('product');
            $table->string('manager_title');
            $table->string('mananger_gender');
            $table->string('manager_id_number');
            $table->string('address');
            $table->string('zip_code');
            $table->string('phone');
            $table->string('cell_phone');
            $table->string('has_certificate');
            $table->string('certificate_id');
            $table->string('certificate_date');
            $table->integer('certificate_type');
            $table->string('has_licence');
            $table->string('licence_id');
            $table->string('licence_date');
            $table->string('licence_source');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
