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
        Schema::create('credential_pensioners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pensioner_id')
                    ->nullable()
                    ->constrained()
                    ->onDelete('restrict');
            $table->dateTime('issued_at', precision: 0);
            $table->dateTime('expires_at', precision: 0);
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
        Schema::dropIfExists('credential_pensioners');
    }
};
