<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_sales')->references('id')->on('sales');
            $table->string('amount', 100)->nullable();
            $table->string('subtotal', 100)->nullable();
            //Datos de generación
            $table->foreignId('id_generation')->references('id')->on('generations');
            $table->string('label_generations', 100)->nullable();
            $table->string('code_generations', 100)->nullable();
            $table->string('start_at_generations', 100)->nullable();
            //datos de usuario
            $table->foreignId('id_user')->references('id')->on('users');
            $table->string('name_user', 100)->nullable();
            $table->string('last_father_name_user', 100)->nullable();
            $table->string('last_mother_name_user', 100)->nullable();
            //datos de usuario
            $table->foreignId('id_payment_rules')->references('id')->on('rule_payments');
            $table->string('name_rule', 100)->nullable();
            $table->string('code_rule', 100)->nullable();
            $table->string('registration_amount_rule', 100)->nullable();
            $table->tinyInteger('is_required_rule')->nullable();
            $table->string('period_rule', 100)->nullable();
            $table->string('id_cat_periodicity_rule');
            $table->string('label_cat_periodicity_rule');
            $table->string('code_cat_periodicity_rule');
            $table->string('id_cat_type_rule');
            $table->string('label_cat_type_rule');
            $table->string('code_cat_type_rule');
            $table->string('id_cat_frequency_rule');
            $table->string('label_cat_frequency_rule');
            $table->string('code_cat_frequency_rule');
            $table->tinyInteger('discount_type_rule')->nullable();
            $table->tinyInteger('included_rule')->nullable();
            //datos de oferta academica
            $table->foreignId('id_commercial_product')->references('id')->on('commercial_product');
            $table->string('label_commercial_product', 100)->nullable();
            $table->string('code_commercial_product', 100)->nullable();
            $table->string('duration_type_commercial_product', 100)->nullable();
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
        Schema::dropIfExists('sales_detail');
    }
}
