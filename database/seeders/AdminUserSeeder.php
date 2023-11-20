<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuarios administradores
        DB::table('users')->insert([
            'name' => 'valen',
            'lastname' => 'morales',
            'username' => 'valenms',
            'email' => 'valentinams419@gmail.com',
            'password' => 'hola123',
            'birthdate' => '1999-04-19',
            'nationality' => 1,
            'created_at' => '2021-04-19 00:00:00',
            'updated_at' => '2021-04-19 00:00:00',
        ]);
        DB::table('users')->insert([
            'name' => 'tomas',
            'lastname' => 'trejos',
            'username' => 'ttrejosg',
            'email' => 'tomastrejos@gmail.com',
            'password' => 'hola123',
            'birthdate' => '1999-04-19',
            'nationality' => 1,
            'created_at' => '2021-04-19 00:00:00',
            'updated_at' => '2021-04-19 00:00:00',
        ]);

        DB::table('users')->insert([
            'name' => 'Carlos',
            'lastname' => 'chitiva',
            'username' => 'cheto59',
            'email' => 'carlosa.paezc@autonoma.edu.co',
            'password' => 'hola123',
            'birthdate' => '1999-04-19',
            'nationality' => 1,
            'created_at' => '2021-04-19 00:00:00',
            'updated_at' => '2021-04-19 00:00:00',
        ]);

        DB::table('adminUsers')->insert([
            'user_id' => 1,
        ]);

        DB::table('adminUsers')->insert([
            'user_id' => 2,
        ]);

        DB::table('adminUsers')->insert([
            'user_id' => 3,
        ]);
    }
}
