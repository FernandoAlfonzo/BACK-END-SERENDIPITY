<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_generation');
            $table->integer('id_coordinator');
            $table->string('module');
            $table->integer('weeks_duration');
            $table->integer('id_teacher');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules_details');
    }
}
