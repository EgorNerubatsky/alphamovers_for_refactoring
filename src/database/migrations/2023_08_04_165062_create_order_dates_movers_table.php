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
        Schema::create('order_dates_movers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullanbe();
            $table->integer('user_mover_id')->unsigned()->nullanbe();
            $table->boolean('is_brigadier')->default(false);
            $table->boolean('is_empty')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_mover_id')->references('id')->on('movers')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_dates_movers');
    }
};
