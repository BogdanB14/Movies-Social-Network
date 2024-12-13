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
            $table->string('genre', 20)->change(); // Zanr filma moze biti maksimalno 20 karaktera
            $table->string('language', 15)->change(); // Jezik filma moze biti maksimalno 15 karaktera
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('genre', 255)->change(); //Zanr se vraca na default maksimalnu duzinu
            $table->string('language', 255)->change(); //Jezik se vraca na default maksimalnu duzinu
        });
    }
};
