<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Person;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    //Migración para la tabla users
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_person')->references('id')->on('persons');
            $table->string('email', 255);
            $table->string('password', 255);

            $table->boolean('is_validate_email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token', 255);
            $table->timestamp('expired_token_at')->nullable();
            $table->char('login_for_google', 1);

            $table->char('status', 1);
            //$table->rememberToken();
            $table->boolean('is_active');
            $table->string('id_adm_organization',100)->nullable();
            $table->integer('created_by')->nullable(); 
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        $idperson = Person::create([
            'name' => 'admin',
            'last_father_name'=>'admin',
            'last_mother_name'=>'admin',
            'status'=>1,
            'is_active'=>true
        ]); 

         User::create([
            'id_person' => $idperson->id,
            'email'=>'admin@admin',
            'password'=>Hash::make('itsolution'),
            'status'=>1,
            'login_for_google'=>0,
            'is_active'=>true
        ]);  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
