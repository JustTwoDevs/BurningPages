<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genres')->insert([
            'name' => 'Novel',
        ]);

        DB::table('genres')->insert([
            'name' => 'Magical realism',
        ]);

        DB::table('genres')->insert([
            'name' => 'Chronicle',
        ]);

        DB::table('genres')->insert([
            'name' => 'Mystery',
        ]);

        DB::table('genres')->insert([
            'name' => 'Suspense',
        ]);

        DB::table('genres')->insert([
            'name' => 'Fiction',
        ]);
    }
}
