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

            'review_id' => 4,
            'bookSaga_id' => 1,
        ]);
        DB::table('bookSagaReviews')->insert([
            'review_id' => 5,
           
            'bookSaga_id' => 1,
        ]);

        DB::table('bookSagaReviews')->insert([
            'review_id' => 6,
         
            'bookSaga_id' => 1,
        ]);
    }
}
