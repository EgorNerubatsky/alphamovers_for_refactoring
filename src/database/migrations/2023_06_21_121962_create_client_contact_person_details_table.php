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
        Schema::create('client_contact_person_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_base_id')->unsigned()->nullable();
            $table->string('complete_name')->nullable();
            $table->string('position')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_base_id', 'fk_client_contact_person_details_client_base_id')
                ->references('id')->on('client_bases')->onDelete('cascade');


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_contact_person_details');
    }
};
