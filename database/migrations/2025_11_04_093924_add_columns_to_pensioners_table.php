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
        Schema::table('pensioners', function (Blueprint $table) {
            $table->string('file_number',10)->nullable()->after('noi_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pensioners', function (Blueprint $table) {
            $table->dropColumn('file_number');
        });
    }
};
