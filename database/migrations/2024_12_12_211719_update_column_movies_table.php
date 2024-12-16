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
            // Add the 'producer' column after 'title' if it doesn't exist
            Schema::table('movies', function (Blueprint $table) {
            if (!Schema::hasColumn('movies', 'producer')) {
                $table->string('producer')->nullable()->after('title');
            }

            // Svi redovi iz kolone 'year_of_release' se lepe u novu kolonu 'year'
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
            // Recreate the 'director' column if it doesn't exist
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
