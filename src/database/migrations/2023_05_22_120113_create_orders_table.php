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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->nullable();
            $table->dateTime('execution_date')->nullable();
            
            $table->text('review')->nullable();
            $table->string('order_source')->nullable();
            $table->string('payment_form')->nullable();
            $table->integer('number_of_workers')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('house')->nullable();
            $table->string('service_type')->nullable();
            $table->text('task_description')->nullable();
            $table->boolean('straps')->default(false);
            $table->boolean('tools')->default(false);
            $table->boolean('respirators')->default(false);
            $table->string('transport')->nullable();
            $table->decimal('order_hrs')->nullable();
            $table->decimal('price_to_customer')->nullable();
            $table->decimal('price_to_workers')->nullable();
            $table->decimal('min_order_amount')->nullable();
            $table->decimal('min_order_hrs')->nullable();
            $table->decimal('total_price')->nullable();
            $table->text('payment_note')->nullable();
            $table->integer('user_manager_id')->unsigned()->nullable();
            $table->integer('user_logist_id')->nullable();
            $table->integer('user_brigadier_id')->nullable();
            $table->string('status')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_manager_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('client_bases')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
