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
        if (!Schema::hasColumn('posts', 'text')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('text')->after('user_id')->nullable(); // Add 'text' column after 'user_id'
            });
        }

        if (Schema::hasColumn('posts', 'content')) {
            DB::statement('UPDATE `posts` SET `text` = `content`'); // Copy 'content' values to 'text'
        }

        if (Schema::hasColumn('posts', 'content')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('content'); // Remove 'content' column
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('posts', 'content')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('content')->after('user_id')->nullable(); // Add 'content' column after 'user_id'
            });
        }
        if (Schema::hasColumn('posts', 'text')) {
            DB::statement('UPDATE `posts` SET `content` = `text`'); // Copy 'text' values to 'content'
        }

        if (Schema::hasColumn('posts', 'text')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('text'); // Remove 'text' column
            });
        }
    }
};
