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
        Schema::create('expenses', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('unit_id')->nullable();
            $table->uuid('expense_category_id');

            $table->date('tanggal');
            $table->decimal('jumlah', 18, 2);

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->index(['tanggal']);
            $table->index(['unit_id']);
            $table->index(['expense_category_id']);
            $table->index(['unit_id', 'tanggal']);

            $table->foreign('unit_id')
                ->references('id')->on('units')
                ->nullOnDelete();

            $table->foreign('expense_category_id')
                ->references('id')->on('expense_categories')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
