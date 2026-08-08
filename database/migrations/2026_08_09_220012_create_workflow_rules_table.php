<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('module');
            $table->string('trigger_event');
            $table->string('condition_field')->nullable();
            $table->string('condition_operator')->nullable();
            $table->string('condition_value')->nullable();
            $table->enum('action_type', ['notify', 'approve', 'auto_post', 'reject']);
            $table->json('action_params')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_rules');
    }
};
