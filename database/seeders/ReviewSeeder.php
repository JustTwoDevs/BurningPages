<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
 {
    /**
    * Run the database seeds.
    */

    public function run(): void
 {
        DB::table( 'reviews' )->insert( [
            'content' => 'creo que es un libro muy bueno',
            'state' => 'published',
            'rate' => 5,
            'user_id' => 1,

        ] );
        DB::table( 'reviews' )->insert( [
            'content' => 'es un desperdicio leer este libro ',
            'state' => 'draft',
            'rate'=> 1.5,
            'user_id' => 2,

        ] );

        DB::table( 'reviews' )->insert( [
            'content' => 'me gustó pero es muy cliché',
            'state' => 'published',
            'rate'=> 3.5,
            'user_id' => 2,

        ] );
        DB::table( 'reviews' )->insert( [
            'content' => 'creo que es una saga muy buena',
            'state' => 'published',
            'rate' => 5,
            'user_id' => 1,

        ] );
        DB::table( 'reviews' )->insert( [
            'content' => 'es un desperdicio leer esta saga ',
            'state' => 'draft',
            'rate'=> 1.5,
            'user_id' => 2,

        ] );

        DB::table( 'reviews' )->insert( [
            'content' => 'me gustó pero es muy cliché',
            'state' => 'published',
            'rate'=> 3.5,
            'user_id' => 2,

        ] );
    }
}
