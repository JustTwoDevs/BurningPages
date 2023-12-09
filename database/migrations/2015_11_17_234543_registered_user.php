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
        Schema::create('registeredUsers', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('user_id')->unique()->nullable(false);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('verified')->default(false)->nullable(false);
            $table->int('likeDifference')->default(0)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registeredUsers');
    }
};
