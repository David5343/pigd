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
        Schema::create('pensioners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subdependency_id')
                    ->nullable()
                    ->constrained()
                    ->onDelete('restrict');
            $table->foreignId('affiliation_status_id')
                    ->nullable()
                    ->constrained('affiliation_statuses')
                    ->onDelete('restrict');
            $table->foreignId('county_id')
                    ->nullable()
                    ->constrained()
                    ->onDelete('restrict');
            $table->foreignId('pension_types_id')
                    ->nullable()
                    ->constrained('pension_types')
                    ->onDelete('restrict');
            $table->string('noi_number', 15)->nullable()->unique();
            $table->date('start_date')->nullable();
            $table->string('observations', 255)->nullable();
            $table->string('last_name_1', 25)->nullable();
            $table->string('last_name_2', 25)->nullable();
            $table->string('name', 45)->nullable();
            $table->date('birthday')->nullable();
            $table->string('sex', 10)->nullable();
            $table->string('marital_status', 255)->nullable();
            $table->string('rfc', 15)->nullable();
            $table->string('curp', 20)->nullable();
            $table->string('phone', 5)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->date('inactive_date')->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('signature', 255)->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted']);
            $table->string('modified_by', 55)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pensioners');
    }
};
