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
        Schema::table('pension_types', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pension_types', function (Blueprint $table) {
            $table->dropSoftDeletes(); 
            $table->enum('status', ['active', 'inactive', 'deleted']);
        });
    }
};
