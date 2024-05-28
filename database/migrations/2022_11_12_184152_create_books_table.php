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
        Schema::create('books', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('title', 100)->nullable(false)->unique();
            $table->mediumText('sinopsis')->nullable(false);
            $table->date('publication_date')->nullable(true);
            $table->string('original_language', 50)->nullable(false);
            $table->double('burningmeter')->nullable(true);
            $table->double('readersScore')->nullable(true);
            $table->string('buyLink', 255)->nullable(false)->unique();
            $table->string('image_path', 255)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
