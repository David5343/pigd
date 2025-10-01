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
            $table->string('file_number', 255)->nullable()->unique();
            $table->unsignedBigInteger('subdependency_id')->nullable();
            $table->foreign('subdependency_id')->references('id')->on('subdependencies');
            $table->date('start_date')->nullable();
            $table->string('observations', 255)->nullable();
            $table->string('last_name_1', 255)->nullable();
            $table->string('last_name_2', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->date('birthday')->nullable();
            $table->string('sex', 255)->nullable();
            $table->string('marital_status', 255)->nullable();
            $table->string('rfc', 255)->nullable();
            $table->string('curp', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->date('inactive_date')->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('signature', 255)->nullable();
            $table->string('affiliate_status', 255)->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted']);
            $table->string('modified_by', 255)->nullable();
            $table->timestamps();
            $table->foreignId('county_id')->nullable()->constrained()->onDelete('restrict');
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
        Schema::dropIfExists('pensioners');
    }
};
