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
            $table->string('title', 50)->change(); // Naziv filma moze biti maksimalno 50 karaktera
            $table->string('genre', 20)->change(); // Zanr filma moze biti maksimalno 20 karaktera
            $table->number('year_of_release')->change(); // Godina objavljivanja ce sada biti number tip podataka
            $table->string('director', 30)->change(); // Reditelj moze biti maksimalno 30 karaktera
            $table->string('language', 15)->change(); // Jezik filma moze biti maksimalno 15 karaktera
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('name', 255)->change(); //Ime se vraca na default maksimalnu duzinu
            $table->string('genre', 255)->change(); //Zanr se vraca na default maksimalnu duzinu
            $table->year('year_of_release')->change(); // Godina objavljivanja se vraca na year
            $table->string('director', 255)->change(); //Reditelj se vraca na default maksimalnu duzinu
            $table->string('language', 255)->change(); //Jezik se vraca na default maksimalnu duzinu
        });
    }
};
