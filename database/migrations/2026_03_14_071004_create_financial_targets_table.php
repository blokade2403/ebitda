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
        Schema::create('financial_targets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('unit_id');
            $table->year('tahun');
            $table->enum('category_type', ['revenue', 'expense']);
            $table->uuid('category_id');
            $table->decimal('amount', 18, 2)->default(0);
            $table->timestamps();
            $table->index(['unit_id', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_targets');
    }
};
