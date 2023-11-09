<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookGenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('book_genres')->insert([
            'book_id' => 1,
            'genre_id' => 1,
        ]);

        DB::table('book_genres')->insert([
            'book_id' => 1,
            'genre_id' => 2,
        ]);

        DB::table('book_genres')->insert([
            'book_id' => 2,
            'genre_id' => 3,
        ]);

        DB::table('book_genres')->insert([
            'book_id' => 2,
            'genre_id' => 4,
        ]);

        DB::table('book_genres')->insert([
            'book_id' => 2,
            'genre_id' => 5,
        ]);

        DB::table('book_genres')->insert([
            'book_id' => 3,
            'genre_id' => 6,
        ]);
    }
}
