<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bank_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            // $table->integer('order_date_id')->unsigned()->nullable();
            $table->dateTime('transaction_date')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('payer')->nullable();
            $table->string('beneficiary')->nullable();
            $table->string('document_number')->nullable();
            // $table->dateTime('order_execution_date')->nullable();
            $table->string('payment_purpose')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            // $table->foreign('order_date_id')->articles('id')->on('order_dates_and_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_operations');
    }
};
