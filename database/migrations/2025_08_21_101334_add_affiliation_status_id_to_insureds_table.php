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
        Schema::table('insureds', function (Blueprint $table) {
            $table->foreignId('affiliation_status_id')
                    ->nullable()
                    ->constrained('affiliation_statuses')
                    ->onDelete('restrict')->after('signature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insureds', function (Blueprint $table) {
        $table->dropForeign(['affiliation_status_id']);
        $table->dropColumn('affiliation_status_id');
        });
    }
};
