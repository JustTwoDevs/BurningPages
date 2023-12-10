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
        Schema::create('bookReviewRates', function (Blueprint $table) {
            $table->id()->autoincrement();
            $table->foreignId('bookReview_id')->nullable(false);
            $table->foreign('bookReview_id')->references('id')->on('bookReviews');
            $table->foreignId('reviewRate_id')->nullable(false);
            $table->foreign('reviewRate_id')->references('id')->on('reviewRates')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewBookRates');
    }
};
