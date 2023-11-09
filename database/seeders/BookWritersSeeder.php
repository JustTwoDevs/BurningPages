<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookWritersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('bookWriters')->insert([
            'book_id' => 1,
            'author_id' => 1,
        ]);

        DB::table('bookWriters')->insert([
            'book_id' => 2,
            'author_id' => 1,
        ]);

        DB::table('bookWriters')->insert([
            'book_id' => 3,
            'author_id' => 2,
        ]);
    }
}
