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
        Schema::create('kanban_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kanban_id')->unsigned()->nullable();
            $table->string('task')->nullable();
            $table->string('task_color')->default('info');
            $table->boolean('completed')->default(false);
            $table->integer('column_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kanban_id')->references('id')->on('kanbans')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kanban_tasks');
    }
};
