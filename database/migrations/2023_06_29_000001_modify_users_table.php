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
            // Add username column if it doesn't exist
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->after('name')->nullable();
            }

            // Add role column
            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['visitor', 'hotel_operator', 'ferry_operator', 'park_operator', 'beach_organizer', 'admin'])->default('visitor')->after('username');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
