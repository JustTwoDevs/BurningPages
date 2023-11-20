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
        Schema::create('bookReviews', function (Blueprint $table) {
            $table->id()->autoincrement();
            $table->double('rate')->nullable(true);
            $table->text('content')->nullable(false);
            $table->foreignId('book_id')->nullable(false);
            $table->foreign('book_id')->references('id')->on('books')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable(false);
            $table->foreign('user_id')->references('id')->on('registeredUsers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('state', ['draft', 'published', 'hidden'])->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookReviews');
    }
};
