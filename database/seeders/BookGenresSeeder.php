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

        DB::table('bookGenres')->insert([
            'book_id' => 1,
            'genre_id' => 1,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 1,
            'genre_id' => 2,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 2,
            'genre_id' => 3,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 2,
            'genre_id' => 4,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 2,
            'genre_id' => 5,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 3,
            'genre_id' => 6,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 4,
            'genre_id' => 7,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 4,
            'genre_id' => 8,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 5,
            'genre_id' => 1,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 5,
            'genre_id' => 7,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 6,
            'genre_id' => 1,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 6,
            'genre_id' => 7,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 7,
            'genre_id' => 1,
        ]);

        DB::table('bookGenres')->insert([
            'book_id' => 7,
            'genre_id' => 7,
        ]);
    }
}
