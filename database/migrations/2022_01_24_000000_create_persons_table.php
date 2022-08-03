<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Person;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    //Migración para la tabla Persons 
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('last_father_name', 100);
            $table->string('last_mother_name', 100);
            $table->char('gender', 1)->nullable();
            $table->date('birth_date')->nullable();
            $table->double('phone')->nullable();
            $table->string('facebook', 100);
            $table->string('interest_list', 100);
            $table->boolean('is_degree')->nullable();
            $table->string('last_degree', 100)->nullable();
            $table->string('last_degree_certificate', 255)->nullable();
            $table->date('graduated_at')->nullable();
            $table->boolean('is_active');
            $table->string('id_adm_organization',100)->nullable();
            $table->integer('created_by')->nullable(); 
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('persons');
    }
}
