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
        Schema::create('credential_insureds', function (Blueprint $table) {
            $table->id();
            $table->dateTime('issued_at', precision: 0);
            $table->dateTime('expires_at', precision: 0);
            $table->unsignedBigInteger('insured_id')->nullable();
            $table->foreign('insured_id')->references('id')->on('insureds');
            $table->string('expiration_types', 255)->nullable();
            $table->string('credential_status', 255)->nullable();
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
        Schema::dropIfExists('credential_insureds');
    }
};
