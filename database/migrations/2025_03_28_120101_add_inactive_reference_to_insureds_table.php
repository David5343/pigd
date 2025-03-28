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
            $table->string('inactive_reference',255)->nullable()->after('inactive_motive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insureds', function (Blueprint $table) {
            $table->dropColumn('inactive_reference'); 
        });
    }
};
