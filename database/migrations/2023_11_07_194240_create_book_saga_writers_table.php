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
        Schema::create('bookSagaWriters', function (Blueprint $table) {
            $table->primary(['bookSaga_id', 'author_id']);
            $table->foreignId('bookSaga_id')->nullable(false);
            $table->foreign('bookSaga_id')->references('id')->on('bookSagas')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('bookSagaWriters');
    }
};
