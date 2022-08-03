<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_modules', function (Blueprint $table) {
            $table->id();
            $table->integer('id_parent')->unsigned();
            $table->string('title',250);
            $table->text('description');
            $table->boolean('active');
            $table->string('id_adm_organization',100)->nullable();
            $table->integer('register_by');
            $table->integer('modify_by');
            $table->timestamps();
        });

        /*sys_module::create([
            'id_parent'=>'0',
            'title'=>'Menús',
            'description'=>'Modulo para creacion de menus',
            'active'=>'1',
            'register_by'=>'1',
            'modify_by'=>'1',
        ]);*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_modules');
    }
}
