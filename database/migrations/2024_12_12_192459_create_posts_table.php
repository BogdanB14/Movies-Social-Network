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
        Schema::create('posts', function (Blueprint $table) {
            $table->id('post_id');
            $table->foreignId('user_id')->references('user_id')->on('users'); // Foreign key to the 'users' table
            $table->string('content'); // Sam tekst o filmu
            $table->string('movie_name'); // Naziv filma
            $table->year('movie_year'); // Datum filma
            $table->foreign('movie_name')->references('name')->on('movies');
            $table->foreign('movie_year')->references('year')->on('movies');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};