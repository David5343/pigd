<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('insureds', function (Blueprint $table) {
            $table->foreignId('county_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('workplace_county_id')
                    ->nullable()
                    ->constrained('counties')
                    ->onDelete('restrict');
            $table->foreignId('birthplace_county_id')
                    ->nullable()
                    ->constrained('counties')
                    ->onDelete('restrict');
            $table->dropForeign(['bank_id']);
            $table->dropColumn('bank_id');
            $table->dropColumn('account_number');
            $table->dropColumn('clabe');
            $table->dropColumn('representative_name');
            $table->dropColumn('representative_rfc');
            $table->dropColumn('representative_curp');
            $table->dropColumn('representative_relationship');
            $table->dropColumn('state');
            $table->dropColumn('county');
            $table->string('file_number', 15)->nullable()->change();
            $table->string('employee_number', 15)->nullable()->after('file_number');
            $table->string('last_name_1', 25)->nullable()->change();
            $table->string('last_name_2', 25)->nullable()->change();
            $table->string('name', 45)->nullable()->change();
            $table->string('blood_type',5)->nullable()->change();
            $table->string('birthplace',50)->nullable()->change();
            $table->string('sex',10)->nullable()->change();
            $table->string('rfc',15)->nullable()->change();
            $table->string('curp',20)->nullable()->change();
            $table->string('phone',15)->nullable()->change();
            $table->string('outdoor_number',10)->nullable()->change();
            $table->string('interior_number',10)->nullable()->change();
            $table->string('cp',7)->nullable()->change();
            $table->string('affiliate_status',20)->nullable()->change();
            $table->string('modified_by',55)->nullable()->change();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insureds', function (Blueprint $table) {
        // Revertir eliminación de columnas
        $table->string('account_number')->nullable();
        $table->string('clabe')->nullable();
        $table->string('representative_name')->nullable();
        $table->string('representative_rfc')->nullable();
        $table->string('representative_curp')->nullable();
        $table->string('representative_relationship')->nullable();

        // Revertir eliminación de foreign key y columna bank_id
        $table->unsignedBigInteger('bank_id')->nullable();
        $table->foreign('bank_id')->references('id')->on('banks')->onDelete('restrict');

        // Revertir soft deletes si antes no existía
        $table->dropSoftDeletes();

        // Eliminar columnas añadidas
        $table->dropColumn('employee_number');
        $table->dropForeign(['county_id']);
        $table->dropColumn('county_id');
            
        });
    }
};
