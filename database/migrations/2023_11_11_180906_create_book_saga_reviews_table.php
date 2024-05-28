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
        Schema::create('bookSagaReviews', function (Blueprint $table) {
            $table->id()->autoincrement();
         
            $table->foreignId('bookSaga_id')->nullable(true);
            $table->foreign('bookSaga_id')->references('id')->on('bookSagas')->cascadeOnUpdate()->cascadeOnDelete();
          
            $table->foreignId('review_id')->constrained('reviews')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookSagaReviews');
    }
};
