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
            $table->string('middle_name')->nullable()->after('first_name'); // Dodata kolona srednje ime
            $table->string('address')->nullable()->after('last_name'); // Dodata kolona adresa user-a
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('middle_name'); //Rollback srednje ime
            $table->dropColumn('address'); //Rollback adrese
        });
    }
};
