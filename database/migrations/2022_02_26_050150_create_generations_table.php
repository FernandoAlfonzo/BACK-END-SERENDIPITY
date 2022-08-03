<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_service')->references('id')->on('commercial_product');
            $table->string('name', 255);
            $table->string('description', 255)->nullable();
            $table->text('modules_teachers');
            $table->int('id_coordinator', 12);
            $table->string('name_coordinator', 255);
            $table->double('discount', 10, 2)->nullable();
            $table->date('start_at');
            $table->date('finish_at');
            $table->string('short_code', 100)->nullable();
            $table->string('code', 150)->nullable();
            $table->string('long_code', 255)->nullable();
            $table->integer('generation');
            $table->string('status', 50);
            $table->double('min_price', 10, 2)->nullable();
            $table->double('max_price', 10, 2)->nullable();
            $table->text('payment_rules');
            $table->double('consider', 10, 2)->nullable();
            $table->string('educative_platform', 50);
            $table->boolean('is_active');
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
        Schema::dropIfExists('generations');
    }
}
