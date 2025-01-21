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
        Schema::create('retirees', function (Blueprint $table) {
            $table->id();
            $table->string('file_number', 255)->nullable();
            $table->string('noi_number', 255)->nullable();
            $table->date('start_date')->nullable();
            $table->string('insured_type', 255)->nullable();
            $table->string('pension_status', 255)->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted']);
            $table->string('modified_by', 255)->nullable();
            $table->unsignedBigInteger('pension_type_id')->nullable();
            $table->foreign('pension_type_id')->references('id')->on('pension_types');
            $table->unsignedBigInteger('insured_id')->nullable();
            $table->foreign('insured_id')->references('id')->on('insureds');
            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retirees');
    }
};
