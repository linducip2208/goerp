<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_advances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->restrictOnDelete();
            $table->foreignId('employee_id')->constrained('employees');
            $table->string('advance_no');
            $table->date('advance_date');
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('purpose')->nullable();
            $table->date('settlement_date')->nullable();
            $table->decimal('settled_amount', 15, 2)->default(0);
            $table->enum('status', ['requested', 'approved', 'paid', 'settled'])->default('requested');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_advances');
    }
};
