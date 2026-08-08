<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_imports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->enum('marketplace', ['shopee', 'tiktok', 'lazada']);
            $table->foreignId('warehouse_id')->constrained()->restrictOnDelete();
            $table->string('filename');
            $table->integer('total_orders')->default(0);
            $table->integer('total_items')->default(0);
            $table->integer('matched_count')->default(0);
            $table->integer('unmatched_count')->default(0);
            $table->integer('duplicate_count')->default(0);
            $table->integer('imported_count')->default(0);
            $table->enum('status', ['uploaded', 'matched', 'previewed', 'imported', 'failed']);
            $table->foreignId('imported_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('imported_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_imports');
    }
};
