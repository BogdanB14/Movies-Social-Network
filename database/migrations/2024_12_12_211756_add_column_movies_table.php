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
            // Check if the 'main_actor' column does not already exist before adding it
            if (!Schema::hasColumn('movies', 'main_actor')) {
                $table->string('main_actor')->nullable()->after('genre'); // Add the 'main_actor' column after 'genre'
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            // Check if the 'main_actor' column exists before dropping it
            if (Schema::hasColumn('movies', 'main_actor')) {
                $table->dropColumn('main_actor'); // Drop the 'main_actor' column
            }
        });
    }
};
