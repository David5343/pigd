<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $lastNumber = (int) DB::table('insureds')
            ->whereNotNull('file_number')
            ->whereRaw('file_number REGEXP ?', ['^T[0-9]+$'])
            ->selectRaw('MAX(CAST(SUBSTRING(file_number, 2) AS UNSIGNED)) as last_number')
            ->value('last_number');

        Schema::create('insured_file_number_counters', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();
            $table->unsignedBigInteger('last_number');
            $table->timestamps();
        });

        DB::table('insured_file_number_counters')->insert([
            'id' => 1,
            'last_number' => $lastNumber,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::create('insured_file_number_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('file_number', 15)->unique();
            $table->timestamp('consumed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insured_file_number_reservations');
        Schema::dropIfExists('insured_file_number_counters');
    }
};
