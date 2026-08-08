<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lock_periods', function (Blueprint $table) {
            if (!Schema::hasColumn('lock_periods', 'tenant_id')) {
                $table->foreignId('tenant_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('lock_periods', 'company_id')) {
                $table->foreignId('company_id')->after('tenant_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('lock_periods', 'period')) {
                $table->string('period')->after('company_id');
            }
            if (!Schema::hasColumn('lock_periods', 'locked_by')) {
                $table->foreignId('locked_by')->nullable()->after('period')->constrained('users')->restrictOnDelete();
            }
            if (!Schema::hasColumn('lock_periods', 'locked_at')) {
                $table->timestamp('locked_at')->nullable()->after('locked_by');
            }
        });

        try {
            Schema::table('lock_periods', function (Blueprint $table) {
                $table->unique(['company_id', 'period']);
            });
        } catch (\Exception $e) {
            //
        }
    }

    public function down(): void
    {
        Schema::table('lock_periods', function (Blueprint $table) {
            $table->dropUnique(['company_id', 'period']);
            $table->dropForeign(['tenant_id']);
            $table->dropForeign(['company_id']);
            $table->dropForeign(['locked_by']);
            $table->dropColumn(['tenant_id', 'company_id', 'period', 'locked_by', 'locked_at']);
        });
    }
};
