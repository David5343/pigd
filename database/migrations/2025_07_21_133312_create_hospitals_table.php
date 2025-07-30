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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name',244)->unique();
            $table->string('address',190)->nullable();
            $table->string('office_phone_1',20)->nullable();
            $table->string('office_phone_2',20)->nullable();
            $table->string('maps_url',50)->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
