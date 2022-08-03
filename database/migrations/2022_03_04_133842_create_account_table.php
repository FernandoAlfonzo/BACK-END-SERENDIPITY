<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_sale')->references('id')->on('sales');
            $table->decimal('original_amount', 5, 2);
            $table->decimal('subtotal', 5, 2);
            //Datos de generación
            // $table->foreignId('id_generation')->references('id')->on('generations');
            // $table->string('label_generations', 100);
            // $table->string('code_generations', 100);
            // $table->string('start_at_generations', 100);
            //datos de usuario
            $table->foreignId('id_user')->references('id')->on('users');
            $table->string('name_user', 100);
            $table->string('last_father_name_user', 100);
            $table->string('last_mother_name_user', 100);
            //datos de usuario
            $table->foreignId('id_payment_rules')->references('id')->on('rule_payments');
            $table->string('name_rule', 100);
            $table->string('code_rule', 100);
            $table->string('registration_amount_rule', 100);
            $table->tinyInteger('is_required_rule');
            $table->string('period_rule', 100);
            $table->string('id_cat_periodicity_rule');
            $table->string('label_cat_periodicity_rule');
            $table->string('code_cat_periodicity_rule');
            $table->string('id_cat_type_rule');
            $table->string('label_cat_type_rule');
            $table->string('code_cat_type_rule');
            $table->string('id_cat_frequency_rule');
            $table->string('label_cat_frequency_rule');
            $table->string('code_cat_frequency_rule');
            $table->tinyInteger('discount_type_rule');
            $table->tinyInteger('included_rule');
            ///datos de venderdor
            $table->foreignId('id_collaborator')->references('id')->on('collaborators');
            $table->string('collaborator_code', 100);
            //datos de oferta academica
            // $table->foreignId('id_commercial_product')->references('id')->on('commercial_product');
            // $table->string('label_commercial_product', 100);
            // $table->string('code_commercial_product', 100);
            // $table->string('duration_type_commercial_product', 100);
             //datos adicionales
             $table->boolean('is_private')->nullable();
             $table->boolean('is_active');
             $table->string('status', 50)->nullable();
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
        Schema::dropIfExists('account');
    }
}
