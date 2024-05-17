<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents_paths', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('lead_id')->unsigned()->nullable();
            // $table->integer('order_date_id')->unsigned()->nullable();
            $table->string('path')->nullable();
            // $table->dateTime('order_execution_date')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('scan_recieved_date')->nullable();
            $table->dateTime('scan_sent_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('order_date_id')->articles('id')->on('order_dates_and_payments')->onDelete('cascade');

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('client_bases')->onDelete('cascade');
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_paths');
    }
};
