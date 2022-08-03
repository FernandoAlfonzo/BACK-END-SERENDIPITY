<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommercialProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_product', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('description', 255)->nullable();
            $table->integer('category');
            $table->double('min_cost');
            $table->double('max_cost');
            $table->foreign('id_type')->references('id')->on('type_service');
            $table->string('short_code', 255)->nullable();
            $table->string('code', 255)->nullable();
            $table->string('long_code', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('url_image', 255)->nullable();
            $table->boolean('is_active');
            $table->string('id_adm_organization',100)->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('commercial_product');
    }
}
