<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_sku_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('marketplace');
            $table->string('marketplace_sku');
            $table->foreignId('product_variant_id')->constrained()->restrictOnDelete();
            $table->boolean('is_auto')->default(false);
            $table->foreignId('mapped_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['tenant_id', 'marketplace', 'marketplace_sku'], 'mkt_sku_mapping_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_sku_mappings');
    }
};
