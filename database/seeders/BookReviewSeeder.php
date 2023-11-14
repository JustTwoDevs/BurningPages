<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bookReviews')->insert([
            'content' => 'creo que es un libro muy bueno',
            'state' => 'published',
            'rate' => 5,
            'user_id' => 1,
            'book_id' => 1,
        ]);
        DB::table('bookReviews')->insert([
            'content' => 'es un desperdicio leer este libro ',
            'state' => 'published',
            'rate'=> 1.5,
            'user_id' => 2,
            'book_id' => 1,
        ]);

        DB::table('bookReviews')->insert([
            'content' => 'me gustó pero es muy cliché',
            'state' => 'published',
            'rate'=> 3.5,
            'user_id' => 2,
            'book_id' => 2,
        ]);
    }
}
