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
        Schema::create('bookCollections', function (Blueprint $table) {
            $table->primary(['book_id', 'bookSaga_id']);
            $table->integer('order')->nullable(false);
            $table->foreignId('book_id')->nullable(false);
            $table->foreign('book_id')->references('id')->on('books')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('bookSaga_id')->nullable(false);
            $table->foreign('bookSaga_id')->references('id')->on('bookSagas')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookCollections');
    }
};
