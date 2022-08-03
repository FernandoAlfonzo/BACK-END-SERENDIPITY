<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserModuleRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_module_rols', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_role')->references('id')->on('roles');
            $table->foreignId('id_sysmodules')->references('id')->on('sys_modules');
            $table->boolean('is_active');
            $table->string('id_adm_organization',100)->nullable();
            $table->text('access_granted');
            $table->integer('register_by')->nullable();
            $table->integer('modify_by')->nullable();
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
        Schema::dropIfExists('user_module_rols');
    }
}
