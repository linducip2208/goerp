<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('marketplace_orders')->cascadeOnDelete();
            $table->string('marketplace_sku');
            $table->string('product_name');
            $table->string('variant')->nullable();
            $table->decimal('quantity', 15, 2);
            $table->decimal('price', 18, 2);
            $table->decimal('discount', 18, 2)->default(0);
            $table->decimal('total', 18, 2);
            $table->foreignId('internal_sku_id')->nullable()->constrained('product_variants')->nullOnDelete();
            $table->enum('match_status', ['matched', 'unmatched'])->default('unmatched');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_order_items');
    }
};
