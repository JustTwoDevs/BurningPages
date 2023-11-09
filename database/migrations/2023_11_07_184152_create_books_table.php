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
            $table->date('publication_date')->nullable(false);
            $table->string('original_language', 50)->nullable(false);
            $table->double('burningmeter')->nullable(false);
            $table->double('readersScore')->nullable(false);
            $table->string('buyLink', 255)->nullable(false)->unique();
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
