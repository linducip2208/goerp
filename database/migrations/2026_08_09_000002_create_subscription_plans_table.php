<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->decimal('price_monthly', 18, 2)->default(0);
            $table->decimal('price_yearly', 18, 2)->default(0);
            $table->integer('max_users')->default(1);
            $table->integer('max_companies')->default(1);
            $table->integer('max_branches')->default(1);
            $table->integer('max_warehouses')->default(1);
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
