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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 255)->nullable();
            $table->string('requester', 255)->nullable();
            $table->date('ticket_date', 255);
            $table->string('procedure_type', 255)->nullable();
            $table->string('requester_movil', 255)->nullable();
            $table->string('insured_type', 255)->nullable();
            $table->unsignedBigInteger('insured_id')->nullable();
            $table->foreign('insured_id')->references('id')->on('insureds');
            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries');
            $table->unsignedBigInteger('retiree_id')->nullable();
            $table->foreign('retiree_id')->references('id')->on('retirees');
            $table->string('ticket_status', 255)->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted']);
            $table->string('modified_by', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
