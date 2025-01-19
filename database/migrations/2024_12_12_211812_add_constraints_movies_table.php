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
                $table->string('genre', 20)->change(); //Ogranicava zanr na maksimalno 20 karaktera
            }

            if (Schema::hasColumn('movies', 'language')) {
                $table->string('language', 15)->change(); //Ogranicava language na maksimum 15 karaktera
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
            $table->string('genre', 255)->change(); // Rollback funkcije up
        }
        if (Schema::hasColumn('movies', 'language')) {
            $table->string('language', 255)->change();
        }

    });
    }
};
