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
        Schema::create('insureds', function (Blueprint $table) {
            $table->id();
            $table->string('file_number', 255)->nullable()->unique();
            $table->unsignedBigInteger('subdependency_id')->nullable();
            $table->foreign('subdependency_id')->references('id')->on('subdependencies');
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->foreign('rank_id')->references('id')->on('ranks');
            $table->date('start_date')->nullable();
            $table->string('work_place', 255)->nullable();
            $table->string('register_motive', 255)->nullable();
            $table->string('observations', 255)->nullable();
            $table->string('last_name_1', 255)->nullable();
            $table->string('last_name_2', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->date('birthday')->nullable();
            $table->string('birthplace', 255)->nullable();
            $table->string('sex', 255)->nullable();
            $table->string('marital_status', 255)->nullable();
            $table->string('rfc', 255)->nullable();
            $table->string('curp', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('county', 255)->nullable();
            $table->string('neighborhood', 255)->nullable();
            $table->string('roadway_type', 255)->nullable();
            $table->string('street', 255)->nullable();
            $table->string('outdoor_number', 255)->nullable();
            $table->string('interior_number', 255)->nullable();
            $table->string('cp', 255)->nullable();
            $table->string('locality', 255)->nullable();
            $table->string('account_number', 255)->nullable();
            $table->string('clabe', 255)->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->date('inactive_date')->nullable();
            $table->date('inactive_date_dependency')->nullable();
            $table->string('inactive_motive', 255)->nullable();
            $table->date('reentry_date')->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('signature', 255)->nullable();
            $table->string('representative_name', 255)->nullable();
            $table->string('representative_rfc', 255)->nullable();
            $table->string('representative_curp', 255)->nullable();
            $table->string('representative_relationship', 255)->nullable();
            $table->string('affiliate_status', 255)->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted']);
            $table->string('modified_by', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insureds');
    }
};
