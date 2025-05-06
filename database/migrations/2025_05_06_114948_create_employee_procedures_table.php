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
        Schema::create('employee_procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained('employees');
            $table->foreignId('procedure_type_id')->nullable()->constrained('procedure_types');
            $table->foreignId('contract_types_id')->nullable()->constrained('contract_types');
            $table->foreignId('area_id')->nullable()->constrained('areas');
            $table->foreignId('position_id')->nullable()->constrained('positions');
            $table->date('start_date')->nullable();
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
        Schema::dropIfExists('employee_procedures');
    }
};
