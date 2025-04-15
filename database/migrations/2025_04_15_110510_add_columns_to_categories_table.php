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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name', 255)->nullable()->change();
            $table->decimal('salary', 10, 2)->nullable()->change();
            $table->decimal('compensation', 10, 2)->nullable()->change();
            $table->decimal('complementary', 10, 2)->nullable()->change();
            $table->decimal('gross_salary', 10, 2)->nullable()->change();
            $table->decimal('isr', 10, 2)->nullable()->change();
            $table->decimal('net_salary', 10, 2)->nullable()->change();
            $table->unsignedTinyInteger('authorized_position')->nullable()->change();
            $table->unsignedTinyInteger('covered_position')->nullable()->change();
            $table->softDeletes()->after('updated_at');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name', 255)->nullable(false)->change();
            $table->decimal('salary', 10, 2)->nullable(false)->change();
            $table->decimal('compensation', 10, 2)->nullable(false)->change();
            $table->decimal('complementary', 10, 2)->nullable(false)->change();
            $table->decimal('gross_salary', 10, 2)->nullable(false)->change();
            $table->decimal('isr', 10, 2)->nullable(false)->change();
            $table->decimal('net_salary', 10, 2)->nullable(false)->change();
            $table->unsignedTinyInteger('authorized_position')->nullable(false)->change();
            $table->unsignedTinyInteger('covered_position')->nullable(false)->change();
            $table->dropSoftDeletes();
            $table->enum('status', ['active', 'inactive', 'deleted']);
        });
    }
};
