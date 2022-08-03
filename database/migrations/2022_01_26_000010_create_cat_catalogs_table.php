<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_catalogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('description');
            $table->string('short_code')->nullable();
            $table->string('code')->nullable();
            $table->string('code2')->nullable();
            $table->string('code3')->nullable();
            $table->string('long_code')->nullable();

            $table->integer('id_cat_types')->unsigned();
            $table->foreign('id_cat_types')->references('id')->on('cat_types');

            $table->string('url_imagen')->nullable();
            $table->tinyInteger('is_active')->nullable();
            $table->tinyInteger('is_private')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('alias')->nullable();
            $table->string('order_number')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('cat_catalogs');
    }
}
