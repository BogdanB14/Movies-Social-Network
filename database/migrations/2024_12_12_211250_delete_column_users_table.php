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
        Schema::table('movies', function (Blueprint $table) {
            // Add the new 'year' column if it doesn't already exist
            if (!Schema::hasColumn('movies', 'year')) {
                $table->year('year')->nullable();
            }
        });


        // Copy data from the old column to the new one
        if (Schema::hasColumn('movies', 'year_of_release')) {
            DB::statement('UPDATE `movies` SET `year` = `year_of_release`');
        }

        // Drop the old column
        Schema::table('movies', function (Blueprint $table) {
            if (Schema::hasColumn('movies', 'year_of_release')) {
                $table->dropColumn('year_of_release');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            // Add the 'year_of_release' column if it doesn't already exist
            if (!Schema::hasColumn('movies', 'year_of_release')) {
                $table->year('year_of_release')->nullable();
            }
        });

        // Copy data from the old column to the new one        if (Schema::hasColumn('movies', 'year')) {
            if (Schema::hasColumn('movies', 'year')) {
                DB::statement('UPDATE `movies` SET `year_of_release` = `year`');
            }

        // Drop the old column
        Schema::table('movies', function (Blueprint $table) {
            if (Schema::hasColumn('movies', 'year')) {
                $table->dropColumn('year');
            }
        });
    }
};
