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
        Schema::create('reviewRates', function (Blueprint $table) {
            $table->primary(['bookReview_id', 'user_id']);
            $table->foreignId('bookReview_id')->nullable(false);
            $table->foreign('bookReview_id')->references('id')->on('bookReviews');
            $table->foreignId('user_id')->nullable(false);
            $table->foreign('user_id')->references('id')->on('registeredUsers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->binary('value')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewRates');
    }
};
