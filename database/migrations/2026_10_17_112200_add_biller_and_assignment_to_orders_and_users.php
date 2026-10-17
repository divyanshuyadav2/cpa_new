<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add biller assignment and billing status to orders table
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'biller_id')) {
                $table->foreignId('biller_id')->nullable()->constrained('users')->nullOnDelete()->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'billing_status')) {
                $table->string('billing_status', 30)->default('pending')->after('status');
            }
            if (!Schema::hasColumn('orders', 'invoice_no')) {
                $table->string('invoice_no', 100)->nullable()->after('billing_status');
            }
            if (!Schema::hasColumn('orders', 'billing_notes')) {
                $table->text('billing_notes')->nullable()->after('invoice_no');
            }
        });

        // Ensure users.role can support 'biller'
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 50)->default('retailer')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['biller_id']);
            $table->dropColumn(['biller_id', 'billing_status', 'invoice_no', 'billing_notes']);
        });
    }
};
