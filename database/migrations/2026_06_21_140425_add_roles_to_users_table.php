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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['salesman', 'retailer'])->default('retailer')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->string('company_name')->nullable()->after('phone');
            $table->text('address')->nullable()->after('company_name');
            $table->boolean('is_active')->default(true)->after('address');
            $table->foreignId('salesman_id')->nullable()->constrained('users')->nullOnDelete()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['salesman_id']);
            $table->dropColumn(['role', 'phone', 'company_name', 'address', 'is_active', 'salesman_id']);
        });
    }
};
