<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nationalities')->insert([
            'name' => 'Colombia',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'United States',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'Mexico',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'Argentina',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'Chile',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'Canada',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'Spain',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'United Kingdom',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'Panama',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'Ecuador',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'France',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'Italy',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'Philipino',
        ]);

        DB::table('nationalities')->insert([
            'name' => 'Germany',
        ]);
    }
}
