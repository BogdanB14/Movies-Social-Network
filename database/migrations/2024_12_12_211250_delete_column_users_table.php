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
            // Add the new column
            $table->year('year')->nullable();
        });

        // Copy data from the old column to the new one
        DB::statement('UPDATE `movies` SET `year` = `year_of_release`');

        // Drop the old column
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('year_of_release');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            // Add the new column
            $table->year('year_of_release')->nullable();
        });

        // Copy data from the old column to the new one
        DB::statement('UPDATE `movies` SET `year_of_release` = `year`');

        // Drop the old column
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
};
