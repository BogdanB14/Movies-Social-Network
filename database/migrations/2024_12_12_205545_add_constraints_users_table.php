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
            $table->string('name', 20)->change(); // Ime user-a moze biti maksimalno 20 karaktera
            $table->string('last_name', 40)->change(); // Prezime user-a moze biti maksimalno 40 karaktera
            $table->year('birth_year')->change(); // Godina rodjenja ce sada biti year tip podataka
            $table->string('username', 30)->change(); // Username moze biti maksimalno 30 karaktera
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 255)->change(); //Ime se vraca na default maksimalnu duzinu
            $table->string('last_name', 255)->change(); //Ime se vraca na default maksimalnu duzinu
            $table->integer('birth_year')->change(); // Godina rodjenja se vraca na nuber
            $table->string('username', 255)->change(); //Ime se vraca na default maksimalnu duzinu
        });
    }
};
