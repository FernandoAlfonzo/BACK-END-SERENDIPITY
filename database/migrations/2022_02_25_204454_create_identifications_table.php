<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_person')->references('id')->on('persons');

            $table->string('code', 100);
            $table->string('code2', 100);
            $table->string('code3', 100);
            $table->string('url_img', 100);
            $table->boolean('is_validate');
            $table->boolean('is_active');
            $table->string('id_adm_organization', 100);
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
        Schema::dropIfExists('identifications');
    }
}
