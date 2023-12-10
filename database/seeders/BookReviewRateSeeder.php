<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookReviewRateSeeder extends Seeder
{
    public function run(): void
    {
            
        DB::table('reviewBookRates')->insert([

           'reviewRate_id' => 1,
              'bookReview_id' => 1,
          ]);
          DB::table('reviewBookRates')->insert([
           'reviewRate_id' => 2,
              'bookReview_id' => 1,
          ]);
  
          DB::table('reviewBookRates')->insert([
        'reviewRate_id' => 3,
              'bookReview_id' => 2,
          ]);
    }
}
