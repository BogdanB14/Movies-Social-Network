<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //Ovo je commit funkcija
    {
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->id("user_id")->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('last_name');
            $table->string('gender');
            $table->date('date_of_registration');
            $table->integer('birth_year');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void //Ovo je rollback funkcija
    {
        Schema::dropIfExists('users');
    }
};
