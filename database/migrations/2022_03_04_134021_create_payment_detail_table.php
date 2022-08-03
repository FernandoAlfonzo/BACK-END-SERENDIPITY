<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_payment')->references('id')->on('payment');
            $table->foreignId('id_account_calendar_detail')->references('id')->on('account_calendar_detail');

            $table->string('folio', 100)->nullable();
            $table->string('folio1', 100)->nullable();
            $table->string('folio2', 100)->nullable();
            $table->string('folio3', 100)->nullable();
            $table->string('description', 100)->nullable();
            $table->date('payment_date', 100)->nullable();
            $table->double('payment_amount', 100)->nullable();
            $table->double('tax_payment_amount', 100)->nullable();
            $table->double('amount', 100)->nullable();
            $table->double('percentage_tax_amount', 100)->nullable();
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
        Schema::dropIfExists('payment_detail');
    }
}
