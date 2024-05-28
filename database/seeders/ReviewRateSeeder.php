<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         
        DB::table('reviewRates')->insert([
          'value' => 1,
            'user_id' => 1,
     
        ]);
        DB::table('reviewRates')->insert([
            'value' => 0,
            'user_id' => 2,
          
        ]);

        DB::table('reviewRates')->insert([
            'value' => 1,
            'user_id' => 2,
          
        ]);
        DB::table('reviewRates')->insert([
            'value' => 1,
              'user_id' => 1,
       
          ]);
          DB::table('reviewRates')->insert([
              'value' => 0,
              'user_id' => 2,
          ]);
  
          DB::table('reviewRates')->insert([
              'value' => 1,
              'user_id' => 2,
            
          ]);
    }
}
