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
        Schema::table('users', function(Blueprint $table){
            $table->string('bank_card')->nullable()->after('gender');
            $table->string('passport_number')->nullable()->after('bank_card');
            $table->string('passport_series')->nullable()->after('passport_number');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('bank_card');
            $table->dropColumn('passport_number');
            $table->dropColumn('passport_series');
        });
    }
};
