<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained()->cascadeOnDelete();
            $table->string('work_order_no');
            $table->string('stage');
            $table->string('team')->nullable();
            $table->string('operator')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('target_qty', 15, 2);
            $table->decimal('actual_qty', 15, 2)->default(0);
            $table->decimal('reject_qty', 15, 2)->default(0);
            $table->decimal('rework_qty', 15, 2)->default(0);
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
