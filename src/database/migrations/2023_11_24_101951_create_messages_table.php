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
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_user_id')->unsigned()->nullable();
            $table->integer('recipient_user_id')->nullable();
            $table->integer('reply_id')->nullable();
            $table->longText('message')->nullable();
            $table->string('attachment_path')->nullable();
            $table->boolean('read')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sender_user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
