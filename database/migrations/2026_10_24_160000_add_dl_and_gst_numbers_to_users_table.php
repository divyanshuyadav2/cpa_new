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
            if (!Schema::hasColumn('users', 'dl_number')) {
                $table->string('dl_number', 100)->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'gst_number')) {
                $table->string('gst_number', 50)->nullable()->after('dl_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'dl_number')) {
                $table->dropColumn('dl_number');
            }
            if (Schema::hasColumn('users', 'gst_number')) {
                $table->dropColumn('gst_number');
            }
        });
    }
};
