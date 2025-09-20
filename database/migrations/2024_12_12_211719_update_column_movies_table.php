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
            Schema::table('movies', function (Blueprint $table) {
            if (!Schema::hasColumn('movies', 'producer')) {
                $table->string('producer')->nullable()->after('title');
            }

            if (Schema::hasColumn('movies', 'producer')){
            DB::statement('UPDATE `movies` SET `producer` = `director`');
            }
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
            if (!Schema::hasColumn('movies', 'director')) {
                $table->string('director')->nullable()->after('producer');
            }
            if(Schema::hasColumn('movies','director')){
            DB::statement('UPDATE `movies` SET `director` = `producer`');
            }
        if (Schema::hasColumn('movies', 'producer')) {
            $table->dropColumn('producer');
        }
    });
    }
};
