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
        Schema::create('daily_finances', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('unit_id');
            $table->date('tanggal');

            // TOP DOWN
            $table->decimal('target_revenue', 18, 2)->default(0);
            $table->decimal('target_doc_variable', 18, 2)->default(0);
            $table->decimal('target_doc_fixed', 18, 2)->default(0);
            $table->decimal('target_ioc', 18, 2)->default(0);

            // BOTTOM UP PLAN
            $table->decimal('plan_revenue', 18, 2)->default(0);
            $table->decimal('plan_doc_variable', 18, 2)->default(0);
            $table->decimal('plan_doc_fixed', 18, 2)->default(0);
            $table->decimal('plan_ioc', 18, 2)->default(0);

            $table->timestamps();

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
        Schema::dropIfExists('daily_finances');
    }
};
