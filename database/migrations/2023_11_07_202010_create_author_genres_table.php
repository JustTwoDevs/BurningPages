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
        Schema::create('authorGenres', function (Blueprint $table) {
            $table->primary(['author_id', 'genre_id']);
            $table->foreignId('author_id')->nullable(false);
            $table->foreign('author_id')->references('id')->on('authors')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('genre_id')->nullable(false);
            $table->foreign('genre_id')->references('id')->on('genres')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authorGenres');
    }
};
