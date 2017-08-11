<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user');
            $table->string('unit_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('id_number');
            $table->integer('gender');
            $table->string('father_name');
            $table->string('birth_date');
            $table->string('birth_place');
            $table->string('habitate');
            $table->string('habitate_years');
            $table->integer('degree');
            $table->integer('field');
            $table->integer('marrige');
            $table->integer('dependents');
            $table->integer('experience');
            $table->string('address');
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
        Schema::dropIfExists('employees');
    }
}
