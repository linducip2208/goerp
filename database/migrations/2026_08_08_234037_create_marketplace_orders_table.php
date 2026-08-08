<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_id')->constrained('marketplace_imports')->cascadeOnDelete();
            $table->string('order_no');
            $table->date('order_date');
            $table->string('order_status')->nullable();
            $table->string('marketplace_item_id');
            $table->timestamps();

            $table->unique(['import_id', 'marketplace_item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_orders');
    }
};
