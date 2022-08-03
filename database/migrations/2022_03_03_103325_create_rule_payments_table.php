<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRulePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rule_payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('code');
            $table->double('registration_amount');
            $table->tinyInteger('is_required');
            $table->string('period');
            $table->string('id_cat_periodicity');
            $table->string('label_cat_periodicity');
            $table->string('code_cat_periodicity');
            $table->string('id_cat_type');
            $table->string('label_cat_type');
            $table->string('code_cat_type');
            $table->string('id_cat_frequency');
            $table->string('label_cat_frequency');
            $table->string('code_cat_frequency');
            $table->tinyInteger('discount');
            $table->tinyInteger('included');
            $table->tinyInteger('is_active');
            $table->string('id_adm_organization',100)->nullable();
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
        Schema::dropIfExists('rule_payments');
    }
}
