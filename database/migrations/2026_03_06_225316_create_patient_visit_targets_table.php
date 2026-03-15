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
        Schema::create('patient_visit_targets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('unit_id');
            $table->uuid('service_id');
            $table->date('tanggal');
            $table->integer('target_pasien');
            $table->timestamps();

             $table->foreign('service_id')
        ->references('id')
        ->on('medical_services')
        ->cascadeOnDelete();

    $table->foreign('unit_id')
        ->references('id')
        ->on('units')
        ->cascadeOnDelete();

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_visit_targets');
    }
};
