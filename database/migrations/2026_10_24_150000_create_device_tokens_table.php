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
        if (!Schema::hasTable('device_tokens')) {
            Schema::create('device_tokens', function (Blueprint $table) {
                $table->id();
                // Morph to User or Admin
                $table->string('tokenable_type', 191);
                $table->unsignedBigInteger('tokenable_id');
                $table->text('token');
                $table->string('platform', 30)->default('android'); // android, ios, web
                $table->timestamps();

                $table->index(['tokenable_type', 'tokenable_id']);
            });
        }

        // Also add fcm_token shortcut directly on users and admins tables for quick single lookup
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'fcm_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('fcm_token')->nullable()->after('remember_token');
            });
        }

        if (Schema::hasTable('admins') && !Schema::hasColumn('admins', 'fcm_token')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->text('fcm_token')->nullable()->after('password');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'fcm_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('fcm_token');
            });
        }

        if (Schema::hasTable('admins') && Schema::hasColumn('admins', 'fcm_token')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('fcm_token');
            });
        }

        Schema::dropIfExists('device_tokens');
    }
};
