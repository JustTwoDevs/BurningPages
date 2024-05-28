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
        Schema::create('sagaReviewRates', function (Blueprint $table) {
            $table->id()->autoincrement();
          
            $table->foreignId('bookSagaReview_id')->nullable(false);
            $table->foreign('bookSagaReview_id')->references('id')->on('bookSagaReviews');
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
        Schema::dropIfExists('sagaReviewRates');
    }
};
