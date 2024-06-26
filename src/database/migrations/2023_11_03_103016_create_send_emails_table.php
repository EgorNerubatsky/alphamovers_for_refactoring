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
        Schema::create('send_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('recipient_name')->nullable();
            $table->string('message')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('recipient_email')->nullable();
            $table->string('subject')->nullable();
            $table->text('attachment_paths')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_emails');
    }
};
