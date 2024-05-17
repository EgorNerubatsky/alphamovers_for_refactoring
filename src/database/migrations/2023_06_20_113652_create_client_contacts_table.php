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
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_base_id')->unsigned()->nullable();

            $table->timestamps();
//            $table->foreign('client_base_id')->references('id')->on('client_bases');
            $table->foreign('client_base_id')->references('id')->on('client_bases')->onDelete('cascade');

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_contacts', function(Blueprint $table){
            $table->dropForeign('client_contacts_client_base_id_foreign');
        });

        Schema::dropIfExists('client_contacts');
    }
};
