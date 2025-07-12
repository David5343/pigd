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
        Schema::create('suppliers', function (Blueprint $table) {
        $table->id();
        $table->string('name',244)->unique();
        $table->string('rfc',15)->nullable(); // si aplica
        $table->string('email',190)->nullable();
        $table->string('office_phone',20)->nullable();
        $table->string('mobile_phone',20)->nullable();
        $table->string('address',190)->nullable();
        $table->enum('type', ['producto', 'servicio', 'ambos'])->default('producto'); // tipo general
        $table->string('modified_by', 50)->nullable();
        $table->timestamps();
        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
