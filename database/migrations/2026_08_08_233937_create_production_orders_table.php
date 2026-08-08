<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('order_no');
            $table->foreignId('product_variant_id')->constrained()->restrictOnDelete();
            $table->foreignId('bom_id')->constrained('production_boms')->restrictOnDelete();
            $table->decimal('target_qty', 15, 2);
            $table->date('start_date');
            $table->date('due_date');
            $table->foreignId('raw_warehouse_id')->constrained('warehouses');
            $table->foreignId('finished_warehouse_id')->constrained('warehouses');
            $table->string('status')->default('draft');
            $table->decimal('actual_output_qty', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_orders');
    }
};
