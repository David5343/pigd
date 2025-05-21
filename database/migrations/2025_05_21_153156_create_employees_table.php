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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // 📄 Información laboral
            $table->foreignId('procedure_type_id')->nullable()->constrained('procedure_types');
            $table->foreignId('contract_type_id')->nullable()->constrained('contract_types');
            $table->foreignId('area_id')->nullable()->constrained('areas');
            $table->foreignId('position_id')->nullable()->constrained('positions');
            $table->foreignId('degree_id')->nullable()->constrained('degrees');
            $table->date('start_date')->nullable();
        
            // 🧍 Información personal
            $table->string('last_name_1', 255)->nullable();
            $table->string('last_name_2', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->date('birthday')->nullable();
            $table->string('sex', 255)->nullable();
            $table->string('marital_status', 255)->nullable();
            $table->string('rfc', 255)->nullable();
            $table->string('curp', 255)->nullable();
            $table->string('ine', 255)->nullable();
            $table->string('academic_level', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('email', 255)->nullable();
        
            // 📞 Contacto
            $table->string('emergency_name', 255)->nullable();
            $table->string('emergency_number', 255)->nullable();
            $table->string('emergency_address', 255)->nullable();
        
            // 📍 Dirección
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedBigInteger('county_id')->nullable();
            $table->foreign('county_id')->references('id')->on('counties');
            $table->string('neighborhood', 255)->nullable();
            $table->string('roadway_type', 255)->nullable();
            $table->string('street', 255)->nullable();
            $table->string('outdoor_number', 255)->nullable();
            $table->string('interior_number', 255)->nullable();
            $table->string('cp', 255)->nullable();
            $table->string('locality', 255)->nullable();
        
            // 🏦 Bancarios
            $table->string('account_number', 255)->nullable();
            $table->string('clabe', 255)->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');
        
            // 🖼️ Archivos
            $table->string('photo', 255)->nullable();
            $table->string('signature', 255)->nullable();
        
            // ⚰️ Baja
            $table->date('inactive_date')->nullable();
            $table->string('inactive_motive', 255)->nullable();
        
            $table->string('modified_by', 255)->nullable();
        
            // ⌛ Tiempos
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
