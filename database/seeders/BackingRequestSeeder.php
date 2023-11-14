<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BackingRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('backingRequests')->insert([
            'content' => 'hola yo soy una persona que ama calificar libros yo merezco ser critico ',
            'state' => 'pending',
            'user_id' => 1,
        ]);
        DB::table('backingRequests')->insert([
            'content' => 'yo no se nada de libros pero quiero ser critico',
            'state' => 'rejected',
            'user_id' => 1,
        ]);

        DB::table('backingRequests')->insert([
            'content' => 'hola yo trabajo para el new york times y soy periodista profesional',
            'state' => 'approved',
            'user_id' => 1,
        ]);

    }
}
