<?php
// database/migrations/2025_09_20_000001_create_movies_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('director');
            $table->unsignedSmallInteger('year');
            $table->string('genre')->nullable();
            $table->text('description')->nullable();
            $table->json('actors')->nullable(); //niz stringova
            $table->string('poster')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
