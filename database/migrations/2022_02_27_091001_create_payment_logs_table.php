<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->integer('merchant_id')->nullable();
            $table->integer('invoiceNumber')->nullable();
            $table->integer('store_name')->nullable();
            $table->string('currency')->nullable();
            $table->float('amount')->nullable();
            $table->string('orderId')->nullable();
            $table->string('successUrl')->nullable();
            $table->string('errorUrl')->nullable();
            $table->string('transactionType')->nullable();
            $table->string('timeout')->nullable();
            $table->string('transactionDateTime')->nullable();
            $table->string('language')->nullable();
            $table->string('txnToken')->nullable();
            $table->string('itemList')->nullable();
            $table->string('otherInfo')->nullable();
            $table->string('merchantCustomerPhone')->nullable();
            $table->string('merchantCustomerEmail')->nullable();
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
        Schema::dropIfExists('payment_logs');
    }
}
