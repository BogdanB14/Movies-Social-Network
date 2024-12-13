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
            Schema::table('posts', function (Blueprint $table) {
                $table->string('text')->after('user_id')->nullable();
            });

            DB::statement('UPDATE `posts` SET `text` = `content`');

            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('content');
            });
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('content')->after('user_id')->nullable();
        });

        DB::statement('UPDATE `posts` SET `content` = `text`');

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('text');
        });
    }
};
