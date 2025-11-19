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
        Schema::create('pensioner_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pensioner_id')
                ->nullable()
                ->constrained()
                ->onDelete('restrict');
            $table->string('file_number', 15)->nullable();
            $table->date('start_date')->nullable();
            $table->string('last_name_1', 25)->nullable();
            $table->string('last_name_2', 25)->nullable();
            $table->string('name', 45)->nullable();
            $table->date('birthday')->nullable();
            $table->string('sex', 10)->nullable();
            $table->string('rfc', 15)->nullable();
            $table->string('curp', 20)->nullable();
            $table->enum('disabled_person', ['SI', 'NO']);
            $table->string('relationship', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('observations', 255)->nullable();
            $table->date('inactive_date')->nullable();
            $table->string('inactive_motive', 55)->nullable();
            $table->string('inactive_reference', 255)->nullable();
            $table->date('reentry_date')->nullable();
            $table->string('photo', 255)->nullable();
            $table->enum('affiliate_status', ['Activo', 'Baja']);
            $table->enum('status', ['active', 'inactive', 'deleted']);
            $table->string('modified_by',55)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pensioner_beneficiaries');
    }
};
