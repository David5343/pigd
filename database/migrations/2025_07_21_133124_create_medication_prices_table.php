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
        Schema::create('medication_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medication_id')->constrained()->onDelete('cascade');
            $table->foreignId('catalog_year_id')->constrained('catalog_years')->onDelete('cascade');
            $table->decimal('unit_price', 10, 2);
            $table->string('modified_by', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['medication_id', 'catalog_year_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medication_prices');
    }
};
