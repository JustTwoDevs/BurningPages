<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BookCollectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bookCollections')->insert([
            'order' => 1,
            'book_id' => 4,
            'bookSaga_id' => 1,
        ]);

        DB::table('bookCollections')->insert([
            'order' => 2,
            'book_id' => 5,
            'bookSaga_id' => 1,
        ]);

        DB::table('bookCollections')->insert([
            'order' => 3,
            'book_id' => 6,
            'bookSaga_id' => 1,
        ]);

        DB::table('bookCollections')->insert([
            'order' => 4,
            'book_id' => 7,
            'bookSaga_id' => 1,
        ]);
    }
}
