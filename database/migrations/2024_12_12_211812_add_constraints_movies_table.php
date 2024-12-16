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
            // Check if the 'genre' column exists before changing it
            if (Schema::hasColumn('movies', 'genre')) {
                $table->string('genre', 20)->change(); // Change genre to a max length of 20
            }

            if (Schema::hasColumn('movies', 'language')) {
                $table->string('language', 15)->change(); // Change language to a max length of 15
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
        if (Schema::hasColumn('movies', 'genre')) {
            $table->string('genre', 255)->change(); // Revert genre to its default max length
        }
        if (Schema::hasColumn('movies', 'language')) {
            $table->string('language', 255)->change(); // Revert language to its default max length
        }

    });
    }
};
