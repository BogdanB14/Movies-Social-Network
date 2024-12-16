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
                if (!Schema::hasColumn('posts', 'likes')) {
                    $table->integer('likes')->nullable()->after('created_at'); // Add column 'likes' after 'created_at'
                }
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('posts', function (Blueprint $table) {
                if (Schema::hasColumn('posts', 'likes')) {
                    $table->dropColumn('likes'); // Remove 'likes' column
                }
            });
        }
};
