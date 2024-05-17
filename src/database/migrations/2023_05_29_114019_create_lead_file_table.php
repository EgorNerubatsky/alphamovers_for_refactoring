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
        Schema::dropIfExists('lead_file');

        Schema::create('lead_file', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lead_id')->unsigned()->nullable();
            $table->integer('file_id')->unsigned()->nullable();
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_file', function (Blueprint $table) {
            $table->dropForeign('lead_file_lead_id_foreign');
        });

        Schema::dropIfExists('lead_file');
    }
};
