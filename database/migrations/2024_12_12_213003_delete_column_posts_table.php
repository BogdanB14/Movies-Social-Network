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
            // Check if the column exists before attempting to drop it
            if (Schema::hasColumn('posts', 'created_at')) {
                $table->dropColumn('created_at'); // Drop the 'created_at' column
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Check if the column does not exist before attempting to add it
            if (!Schema::hasColumn('posts', 'created_at')) {
                $table->timestamp('created_at')->after('movie_id')->nullable(); // Add 'created_at' column
            }
        });
    }
};
