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
        Schema::table('users', function (Blueprint $table) {
        if (Schema::hasColumn('users', 'name')) {
            $table->string('name', 20)->change();
        }

        if (Schema::hasColumn('users', 'last_name')) {
            $table->string('last_name', 40)->change();
        }

        if (Schema::hasColumn('users', 'username')) {
            $table->string('username', 30)->change();
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'name')) {
                $table->string('name', 255)->change();
            }

            if (Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name', 255)->change();
            }

            if (Schema::hasColumn('users', 'username')) {
                $table->string('username', 255)->change();
            }
        });
    }
};
