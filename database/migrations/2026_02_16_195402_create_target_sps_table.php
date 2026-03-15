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
        Schema::create('target_sps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('bulan')->nullable();
            $table->string('bulan')->nullable();
            $table->bigInteger('target')->nullable();
            $table->string('nama_tahun_anggaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_sps');
    }
};
