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
            // Dodaje kolonu producer ako vec ne postoji u tabeli nakon kolone title
            Schema::table('movies', function (Blueprint $table) {
            if (!Schema::hasColumn('movies', 'producer')) {
                $table->string('producer')->nullable()->after('title');
            }

            // Svi redovi iz kolone 'director' se lepe u novu kolonu ''producer
            if (Schema::hasColumn('movies', 'producer')){
            DB::statement('UPDATE `movies` SET `producer` = `director`');
            }
            // Brise se stara kolona
            if (Schema::hasColumn('movies', 'director')) {
                $table->dropColumn('director');
            }
        });
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            //Dodaje kolonu director ako vec ne postoji u tabeli nakon kolone title
            if (!Schema::hasColumn('movies', 'director')) {
                $table->string('director')->nullable()->after('producer');
            }
            if(Schema::hasColumn('movies','director')){
            DB::statement('UPDATE `movies` SET `director` = `producer`');
            }
        //Obrnuti proces od metode up()
        if (Schema::hasColumn('movies', 'producer')) {
            $table->dropColumn('producer');
        }
    });
    }
};
