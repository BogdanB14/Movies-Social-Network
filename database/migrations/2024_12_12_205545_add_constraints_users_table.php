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
            $table->string('name', 20)->change(); // Name can be a maximum of 20 characters
        }

        // Check if 'last_name' column exists before changing
        if (Schema::hasColumn('users', 'last_name')) {
            $table->string('last_name', 40)->change(); // Last name can be a maximum of 40 characters
        }

        // Check if 'username' column exists before changing
        if (Schema::hasColumn('users', 'username')) {
            $table->string('username', 30)->change(); // Username can be a maximum of 30 characters
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert 'name' column to its default length
            if (Schema::hasColumn('users', 'name')) {
                $table->string('name', 255)->change(); // Name reverts to default max length of 255
            }

            // Revert 'last_name' column to its default length
            if (Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name', 255)->change(); // Last name reverts to default max length of 255
            }

            // Revert 'username' column to its default length
            if (Schema::hasColumn('users', 'username')) {
                $table->string('username', 255)->change(); // Username reverts to default max length of 255
            }
        });
    }
};
