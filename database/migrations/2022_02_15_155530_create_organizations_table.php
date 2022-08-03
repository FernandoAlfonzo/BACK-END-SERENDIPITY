<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name_commercial', 100);
            $table->string('name_business', 100);
            $table->string('address', 100);
            $table->string('RFC', 100);
            $table->double('phone', 100);
            $table->double('email', 100);
            $table->double('social_networks', 100)->nullable(); 
            $table->string('url_logo')->nullable();
            $table->string('code', 100);
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
        Schema::dropIfExists('organizations');
    }
}
