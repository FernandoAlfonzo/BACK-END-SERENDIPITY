<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaboratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_person')->references('id')->on('persons');
            $table->string('collaborator_code', 100)->nullable();
            $table->integer('collaborator_type');
            $table->string('description', 255)->nullable();
            $table->date('start_at');
            $table->date('finished_at')->nullable();
            $table->text('office_id');
            $table->string('area', 100);
            $table->string('activities', 255)->nullable();
            $table->char('status', 1)->default('1');
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
        Schema::dropIfExists('collaborators');
    }
}
