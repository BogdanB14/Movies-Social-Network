<?php
// database/migrations/2025_09_20_000003_create_comments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('by_user')->constrained('users')->cascadeOnDelete();  
            $table->foreignId('for_movie')->constrained('movies')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->index(['for_movie', 'by_user']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
