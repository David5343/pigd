<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insured_file_number_reservations', function (Blueprint $table) {
            $table->enum('source', ['web', 'api'])
                ->default('web')
                ->after('file_number');
        });
    }

    public function down(): void
    {
        Schema::table('insured_file_number_reservations', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};
