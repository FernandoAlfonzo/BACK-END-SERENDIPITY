<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_service', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('description', 255)->nullable();
            $table->string('short_code', 255)->nullable();
            $table->string('code', 255)->nullable();
            $table->string('long_code', 255)->nullable();
            $table->boolean('is_active');
            $table->char('status', 1)->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->string('url_image', 255)->nullable();
            $table->string('id_adm_organization',100)->nullable();
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
        Schema::dropIfExists('type_service');
    }
}
