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
            'value' => 1,
              'user_id' => 1,
              'bookSagaReview_id' => 1,
          ]);
          DB::table('sagaReviewRates')->insert([
              'value' => 0,
              'user_id' => 2,
              'bookSagaReview_id' => 1,
          ]);
  
          DB::table('sagaReviewRates')->insert([
              'value' => 1,
              'user_id' => 2,
              'bookSagaReview_id' => 2,
          ]);
    }
}
