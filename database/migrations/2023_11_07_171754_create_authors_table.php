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
        Schema::create('authors', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name', 100)->nullable(false);
            $table->string('lastname', 100)->nullable(false);
            $table->string('pseudonym', 100)->nullable(false)->unique();
            $table->date('birth_date')->nullable(false);
            $table->date('death_date')->nullable(true);
            $table->longText('biography')->nullable(false);
            $table->foreignId('nationality_id')->nullable(false);
            $table->foreign('nationality_id')->references('id')->on('nationalities')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('image_path', 255)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
