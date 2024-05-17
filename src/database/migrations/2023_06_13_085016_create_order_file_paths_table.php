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
        Schema::create('order_file_paths', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id')->nullable();
            $table->string('path')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('scan_recieved_date')->nullable();
            $table->dateTime('scan_sent_date')->nullable();            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_file_paths');
    }
};
