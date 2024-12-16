<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the new column after 'date_of_registration'
            $table->year('year')->nullable()->after('date_of_registration');
        });

        // Transfer the data from the 'birth_year' column to the new 'year' column
        DB::statement('UPDATE `users` SET `year` = `birth_year`');

        // Drop the old 'birth_year' column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birth_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add the 'birth_year' column back
        Schema::table('users', function (Blueprint $table) {
            $table->year('birth_year')->nullable()->after('date_of_registration');
        });

        // Transfer the data from the 'year' column back to the 'birth_year' column
        DB::statement('UPDATE `users` SET `birth_year` = `year`');

        // Drop the 'year' column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
};
