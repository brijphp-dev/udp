<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('payment_ammount')->nullable();
            $table->string('payment_currency')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_message')->nullable();
            $table->string('payment_payer_email')->nullable();
            $table->string('payment_payer_firstname')->nullable();
            $table->string('payment_payer_lastname')->nullable();
            $table->string('payment_payer_id')->nullable();
            $table->string('payment_datetime')->nullable();
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
        Schema::dropIfExists('user_payments');
    }
}
