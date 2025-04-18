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
        Schema::create('categories', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('name', 255)->unique();
            $table->decimal('salary', $precision = 10, $scale = 2);
            $table->decimal('compensation', $precision = 10, $scale = 2);
            $table->decimal('complementary', $precision = 10, $scale = 2);
            $table->decimal('gross_salary', $precision = 10, $scale = 2);
            $table->decimal('isr', $precision = 10, $scale = 2);
            $table->decimal('net_salary', $precision = 10, $scale = 2);
            $table->unsignedTinyInteger('authorized_position');
            $table->unsignedTinyInteger('covered_position');
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
        Schema::dropIfExists('categories');
    }
};
