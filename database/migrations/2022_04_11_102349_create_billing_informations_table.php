<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_informations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_person')->references('id')->on('persons');
            $table->string('name', 100)->nullable();
            $table->string('tax_regime', 100)->nullable();
            $table->string('cat_id_type_person_billing', 100)->nullable();
            $table->string('cat_label_type_person_billing', 100)->nullable();
            $table->string('RFC', 100)->nullable();
            $table->string('cat_id_CFDI', 100)->nullable();
            $table->string('cat_label_CFDI', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('cat_id_type_payment', 100)->nullable();
            $table->string('cat_label_type_payment', 100)->nullable();
            $table->string('cat_id_way_to_pay', 100)->nullable();
            $table->string('cat_label_way_to_pay', 100)->nullable();
            $table->string('cat_id_currency', 100)->nullable();
            $table->string('cat_label_currency', 100)->nullable();

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
        Schema::dropIfExists('billing_informations');
    }
}
