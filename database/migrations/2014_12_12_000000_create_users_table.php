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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoincrement();
            $table->string('name', 255)->nullable(false);
            $table->string('lastname', 255)->nullable(false);
            $table->string('username', 255)->unique()->nullable(false);
            $table->string('email', 255)->unique()->nullable(false);
            $table->string('password', 255)->nullable(false);
            $table->date('birthdate')->nullable(false);
            $table->foreignId('nationality');
            $table->foreign('nationality')->references('id')->on('nationalities')->restrictOnUpdate()->restrictOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
