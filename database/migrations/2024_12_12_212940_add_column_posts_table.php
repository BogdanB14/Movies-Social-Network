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
            Schema::table('posts', function (Blueprint $table) {
                $table->bigint('likes')->nullable()->after('created_at'); // Dodata kolona broj lajkova nakon vreme kreiranja
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('likes'); //Rollback broja lajkova
            });
        }
};
