<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SagaReviewRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            
        DB::table('sagaReviewRates')->insert([

           'reviewRate_id' => 4,
              'bookSagaReview_id' => 1,
          ]);
          DB::table('sagaReviewRates')->insert([
           'reviewRate_id' => 5,
              'bookSagaReview_id' => 1,
          ]);
  
          DB::table('sagaReviewRates')->insert([
        'reviewRate_id' => 6,
              'bookSagaReview_id' => 2,
          ]);
    }
}
