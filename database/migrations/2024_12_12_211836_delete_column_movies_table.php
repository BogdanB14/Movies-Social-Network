<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (Schema::hasColumn('movies', 'language')) {
            Schema::table('movies', function (Blueprint $table) {
                $table->dropColumn('language'); //Brise kolonu langugage
            });
        }
    }


    public function down(): void
    {
        if (!Schema::hasColumn('movies', 'language')) {
            Schema::table('movies', function (Blueprint $table) {
                $table->string('language'); // Rollback funkcije up
            });
        }
    }
};
