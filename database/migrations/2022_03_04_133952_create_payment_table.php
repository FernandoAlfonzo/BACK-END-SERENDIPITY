<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_account')->references('id')->on('account');

            $table->string('id_cat_currency', 100)->nullable();
            $table->string('currency_name', 100)->nullable();
            $table->string('currency_code', 100)->nullable();

            $table->string('id_cat_method', 100)->nullable();
            $table->string('method_name', 100)->nullable();
            $table->string('method_code', 100)->nullable();

            $table->string('id_cat_payment_type', 100)->nullable();
            $table->string('payment_type_name', 100)->nullable();
            $table->string('payment_type_code', 100)->nullable();

            $table->string('payment_code', 100)->nullable();

            $table->string('id_cat_way', 100)->nullable();
            $table->string('way_name', 100)->nullable();
            $table->string('way_code', 100)->nullable();

            $table->string('id_cat_source', 100)->nullable();
            $table->string('source_name', 100)->nullable();
            $table->string('source_code', 100)->nullable();

            $table->string('id_type_source', 100)->nullable();
            $table->string('source', 100)->nullable();
            $table->string('type_source_name', 100)->nullable();
            $table->string('type_source_code', 100)->nullable();

            $table->string('id_source', 100)->nullable();
            $table->string('source_name_aux', 100)->nullable();
            $table->string('source_code_aux', 100)->nullable();
            
            $table->string('id_charge_type', 100)->nullable();
            $table->string('charge_type_name', 100)->nullable();
            $table->string('charge_type_code', 100)->nullable();

            $table->double('client_account')->nullable();
            $table->string('folio', 100)->nullable();
            $table->string('folio1', 100)->nullable();
            $table->string('folio2', 100)->nullable();
            $table->string('folio3', 100)->nullable();
            $table->string('description', 100)->nullable();
            $table->date('payment_date', 100)->nullable();
            $table->double('amount', 100)->nullable();
            $table->string('user_comment', 100)->nullable();
            $table->string('system_comment', 100)->nullable();
            $table->string('status', 100)->nullable();

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
        Schema::dropIfExists('payment');
    }
}
