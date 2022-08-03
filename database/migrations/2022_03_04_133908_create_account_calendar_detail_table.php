<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountCalendarDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_calendar_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_account')->references('id')->on('account');

            $table->date('date_calendar', 100)->nullable();
            $table->boolean('is_not_required')->nullable();
            $table->string('status', 100)->nullable();
            $table->string('system_comment', 100)->nullable();
            $table->double('original_amount', 100)->nullable();
            $table->double('tax_charge_amount', 100)->nullable();
            $table->double('charge_amount', 100)->nullable();
            $table->double('tax_payment_amount', 100)->nullable();
            $table->double('payment_amount', 100)->nullable();
            $table->double('order_number', 100)->nullable();
            $table->double('order_number_calendar', 100)->nullable();
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
        Schema::dropIfExists('calendar_detail');
    }
}
