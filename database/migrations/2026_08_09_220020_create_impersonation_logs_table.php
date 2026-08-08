<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impersonation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('platform_admin_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('target_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->string('reason')->nullable();
            $table->json('activity_log')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impersonation_logs');
    }
};
