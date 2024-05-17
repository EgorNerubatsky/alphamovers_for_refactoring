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
        Schema::create('client_bases', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date_of_contract')->nullable();
            $table->string('company')->nullable();
            $table->string('type')->nullable();
            $table->decimal('debt_ceiling')->nullable();
            $table->string('identification_number')->nullable();
            $table->string('code_of_the_reason_for_registration')->nullable();
            $table->string('main_state_registration_number')->nullable();
            $table->string('director_name')->nullable();
            $table->string('contact_person_position')->nullable();
            $table->string('acting_on_the_basis_of')->nullable();
            $table->string('registered_address')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('payment_account')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_identification_code')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_bases');
    }
};
