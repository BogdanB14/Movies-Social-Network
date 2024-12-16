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
            // Check if the 'middle_name' column does not exist before adding it
            if (!Schema::hasColumn('users', 'middle_name')) {
                $table->string('middle_name')->nullable()->after('name'); // Adding 'middle_name' column
            }

            // Check if the 'address' column does not exist before adding it
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('last_name'); // Adding 'address' column
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if 'middle_name' column exists before attempting to drop it
            if (Schema::hasColumn('users', 'middle_name')) {
                $table->dropColumn('middle_name'); // Dropping the 'middle_name' column
            }

            // Check if 'address' column exists before attempting to drop it
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address'); // Dropping the 'address' column
            }
        });
    }
};
