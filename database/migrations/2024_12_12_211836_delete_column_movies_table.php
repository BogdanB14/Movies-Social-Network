<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (Schema::hasColumn('movies', 'director')) {
            Schema::table('movies', function (Blueprint $table) {
                $table->dropColumn('director');
            });
        }
    }


    public function down(): void
    {
        if (!Schema::hasColumn('movies', 'director')) {
            Schema::table('movies', function (Blueprint $table) {
                $table->string('director');
            });
        }
    }
};
