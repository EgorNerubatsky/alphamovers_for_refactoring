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
        Schema::create('movers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->dateTime('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('bank_card')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_series')->nullable();
            $table->string('advantages')->nullable();
            $table->string('note')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movers');
    }
};