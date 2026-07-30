<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * - Makes company_id, division_id, salt_id, composition, packing nullable
     *   so that CSV imports with partial data don't crash.
     * - Adds hsn_code, tax, a_tax, pur columns to store price-list fields.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Make foreign keys nullable (CSV may not always provide division/salt)
            $table->unsignedBigInteger('company_id')->nullable()->change();
            $table->unsignedBigInteger('division_id')->nullable()->change();
            $table->unsignedBigInteger('salt_id')->nullable()->change();

            // Make text fields nullable (CSV may not include these)
            $table->string('composition')->nullable()->change();
            $table->string('packing')->nullable()->change();

            // New columns from the price-list CSV
            $table->string('hsn_code')->nullable()->after('name');
            $table->decimal('tax', 10, 2)->nullable()->after('pts');
            $table->decimal('a_tax', 10, 2)->nullable()->after('tax');
            $table->decimal('pur', 10, 2)->nullable()->after('a_tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['hsn_code', 'tax', 'a_tax', 'pur']);

            // Revert nullable changes
            $table->unsignedBigInteger('company_id')->nullable(false)->change();
            $table->unsignedBigInteger('division_id')->nullable(false)->change();
            $table->unsignedBigInteger('salt_id')->nullable(false)->change();
            $table->string('composition')->nullable(false)->change();
            $table->string('packing')->nullable(false)->change();
        });
    }
};
