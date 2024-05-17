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
        Schema::table('order_dates_movers',function(Blueprint $table){
            $table->decimal('bonus')->nullable()->default(false)->after('paid');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_dates_movers', function (Blueprint $table){
            $table->dropColumn('bonus');
        });
    }
};
