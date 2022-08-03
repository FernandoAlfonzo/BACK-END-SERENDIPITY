<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->string('folio', 100);
            $table->date('date_sale')->nullable();
            $table->date('time_sale')->nullable();

            $table->foreignId('id_salesman')->references('id')->on('collaborators');
            $table->foreignId('id_student')->references('id')->on('students');

            $table->string('type_payment', 100);
            $table->string('subtotal', 100);
            $table->string('iva', 100);
            $table->string('total', 100);

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
        Schema::dropIfExists('sales');
    }
}
