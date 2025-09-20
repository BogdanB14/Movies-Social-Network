<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('password');
            }

            if (!Schema::hasColumn('users', 'user_name')) {
                $table->string('user_name')->nullable()->after('email');
            }
        });

        if (Schema::hasColumn('users', 'username') && Schema::hasColumn('users', 'user_name')) {
            DB::table('users')->whereNull('user_name')->update([
                'user_name' => DB::raw('username'),
            ]);
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'user_name')) {
                $table->unique('user_name', 'users_user_name_unique');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->after('email');
            }
        });
        if (Schema::hasColumn('users', 'user_name') && Schema::hasColumn('users', 'username')) {
            DB::table('users')->whereNull('username')->update([
                'username' => DB::raw('user_name'),
            ]);
        }

        Schema::table('users', function (Blueprint $table) {
            try { $table->dropUnique('users_user_name_unique'); } catch (\Throwable $e) {}
            if (Schema::hasColumn('users', 'user_name')) {
                $table->dropColumn('user_name');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};
