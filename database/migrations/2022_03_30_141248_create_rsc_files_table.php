<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRscFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rsc_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->references('id')->on('users');
            $table->foreignId('id_notification')->references('id')->on('notifications');
            $table->string('cat_mime_type', 100)->nullable();
            $table->string('content_type', 100)->nullable();
            $table->boolean('default_file');
            $table->string('extention', 100)->nullable();
            $table->boolean('is_blob');
            $table->string('path_file', 100)->nullable();
            $table->mediumText('resource_file')->nullable();
            $table->boolean('is_downloadable');
            $table->boolean('is_image');
            //datos adicionales
            $table->boolean('is_private')->nullable();
            $table->boolean('is_active');
            $table->string('alias1', 100)->nullable();
            $table->string('alias2', 100)->nullable();
            $table->string('alias3', 100)->nullable();
            $table->string('short_code', 100)->nullable();
            $table->string('code', 100)->nullable();
            $table->string('long_code', 100)->nullable();
            $table->string('id_adm_organization',100)->nullable();
            $table->string('name_adm_organization',100)->nullable();
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
        Schema::dropIfExists('rsc_files');
    }
}
