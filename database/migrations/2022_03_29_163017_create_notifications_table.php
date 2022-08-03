<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->references('id')->on('users');
            $table->string('label', 100)->nullable();
            $table->string('description', 100)->nullable();
            $table->string('cat_type_notification_id', 100)->nullable();
            $table->string('cat_type_notification_code', 100)->nullable();
            $table->string('cat_type_notification_label', 100)->nullable();
            $table->string('status', 100)->nullable();
            $table->boolean('is_view')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
