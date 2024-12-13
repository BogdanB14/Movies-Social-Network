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
    { //Na internetu smo nasli funkciju RENAME COLUMN koja nije kompatibilna sa ovom verzijom
        Schema::table('users', function(Blueprint $table){
            Schema::table('users', function (Blueprint $table) {
                //Nova kolona se dodaje u tabelu
                $table->year('year')->after('date_of_registration')->nullable();
            });

            // Vrednosti iz kolone koju brisem stavljam u novu kolonu
            DB::statement('UPDATE `users` SET `year` = `birth_year`');

            //Brisem staru kolonu
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('birth_year');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Obrnuti proces od up() funkcije
        Schema::table('users', function(Blueprint $table){
            Schema::table('users', function (Blueprint $table) {
                $table->year('birth_year')->nullable();
            });


            DB::statement('UPDATE `users` SET `birth_year` = `year`');


            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('year');
            });
        });
    }
};
