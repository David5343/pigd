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
        Schema::create('employee_procedure_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_procedure_id')->constrained()->onDelete('cascade');
            // Solo se llenan si aplica
            $table->string('old_area_name', 255)->nullable();
            $table->string('new_area_name', 255)->nullable();
            $table->string('old_position_name', 255)->nullable();
            $table->string('new_position_name', 255)->nullable();
            $table->string('old_category_name', 255)->nullable();
            $table->string('new_category_name', 255)->nullable();
            $table->string('old_salary', 255)->nullable();
            $table->string('new_salary', 255)->nullable();
            $table->string('modified_by', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_procedure_details');
    }
};
