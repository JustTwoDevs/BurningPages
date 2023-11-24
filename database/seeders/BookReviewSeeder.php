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
            'review_id' => 1,
        
            'book_id' => 1,
      
        ]);
        DB::table('bookReviews')->insert([
            'review_id' => 2,
            
            'book_id' => 1,
       
        ]);

        DB::table('bookReviews')->insert([
            'review_id' => 3,
            'book_id' => 2,
          
        ]);
    }
}
