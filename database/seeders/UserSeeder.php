<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'valen',
            'email' => 'valentinams419@gmail.com',
            'password' => 'hola123',
            
        ]);
        DB::table('users')->insert([
            'name' => 'tomas ',
            'email' => 'tomastrejos@gmail.com',
            'password'=> 'hola123',
           
        ]);

        DB::table('users')->insert([
            'name' => 'Carlos',
            'email' => 'cheto69@gmail.com',
            'password' => 'hola123',
          
        ]);
    }
}
