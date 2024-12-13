<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //I ovde smo imali problem sa metodom koja nije kompatibilna sa verzijom MariaDB
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            Schema::table('movies', function (Blueprint $table) {
                // Nova kolona 'year' koja menja kolonu 'year_of_release'
                $table->string('producer')->after('title')->nullable();
            });

            // Svi redovi iz kolone 'year_of_release' se lepe u novu kolonu 'year'
            DB::statement('UPDATE `movies` SET `producer` = `director`');

            // Brise se stara kolona
            Schema::table('movies', function (Blueprint $table) {
                $table->dropColumn('director');
            });
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->year('director')->nullable();
        });

        DB::statement('UPDATE `movies` SET `director` = `producer`');
        //Obrnuti proces od metode up()
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('producer');
        });
    }
};
