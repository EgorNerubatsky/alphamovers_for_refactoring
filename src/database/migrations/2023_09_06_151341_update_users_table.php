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
        Schema::table('users', function (Blueprint $table){
            $table->dateTime('birth_date')->nullable()->after('photo_path');
            $table->string('gender')->nullable()->after('birth_date');
            // $table->string('note')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('birth_date');
            $table->dropColumn('gender');
            // $table->dropColumn('note');
        });
    }
};
