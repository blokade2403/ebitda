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
        Schema::create('medical_services', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('unit_id');
            $table->uuid('revenue_category_id');
            $table->string('nama_layanan');
            $table->decimal('tarif', 18, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('unit_id')
                ->references('id')
                ->on('units')
                ->cascadeOnDelete();
            $table->foreign('revenue_category_id')
                ->references('id')
                ->on('revenue_categories')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_services');
    }
};
