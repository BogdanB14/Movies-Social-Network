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
        if (Schema::hasColumn('posts', 'text')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('text', 150)->change(); // Limit 'text' to 150 characters
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('posts', 'text')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('text', 255)->change(); // Revert 'text' to default 255 characters
            });
        }
    }
};
