<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSagaReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('bookSagaReviews')->insert([
            'content' => 'creo que es una saga muy buena',
            'state' => 'published',
            'rate' => 5,
            'user_id' => 1,
            'bookSaga_id' => 1,
        ]);
        DB::table('bookSagaReviews')->insert([
            'content' => 'es un desperdicion leer esta saga ',
            'state' => 'published',
            'rate'=> 1.5,
            'user_id' => 2,
            'bookSaga_id' => 1,
        ]);

        DB::table('bookSagaReviews')->insert([
            'content' => 'me gustó pero es muy cliché',
            'state' => 'published',
            'user_id' => 2,
            'bookSaga_id' => 1,
        ]);
    }
}
