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
        // Primero eliminar la columna retiree_id y su foreign key en tickets
        if (Schema::hasTable('tickets') && Schema::hasColumn('tickets', 'retiree_id')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropForeign(['retiree_id']); // eliminar FK
                $table->dropColumn('retiree_id');    // eliminar columna
            });
        }

        // Luego eliminar las tablas
        Schema::dropIfExists('credential_retirees');
        Schema::dropIfExists('retirees');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
