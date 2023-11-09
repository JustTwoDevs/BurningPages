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
        Schema::create('bookWriters', function (Blueprint $table) {
            $table->primary(['book_id', 'author_id']);
            $table->foreignId('book_id')->nullable(false);
            $table->foreign('book_id')->references('id')->on('books')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('author_id')->nullable(false);
            $table->foreign('author_id')->references('id')->on('authors')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookWriters');
    }
};
