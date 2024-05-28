<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuarios administradores
        User::create([
            'name' => 'valen',
            'lastname' => 'morales',
            'username' => 'valenms',
            'email' => 'valentinams419@gmail.com',
            'password' => 'hola123',
            'birthdate' => '1999-04-19',
            'nationality_id' => 1,
            'created_at' => '2021-04-19 00:00:00',
            'updated_at' => '2021-04-19 00:00:00',
        ]);
        User::create([
            'name' => 'tomas',
            'lastname' => 'trejos',
            'username' => 'ttrejosg',
            'email' => 'tomastrejos@gmail.com',
            'password' => 'hola123',
            'birthdate' => '1999-04-19',
            'nationality_id' => 1,
            'created_at' => '2021-04-19 00:00:00',
            'updated_at' => '2021-04-19 00:00:00',
        ]);

        User::create([
            'name' => 'Carlos',
            'lastname' => 'chitiva',
            'username' => 'cheto59',
            'email' => 'carlosa.paezc@autonoma.edu.co',
            'password' => 'hola123',
            'birthdate' => '1999-04-19',
            'nationality_id' => 1,
            'created_at' => '2021-04-19 00:00:00',
            'updated_at' => '2021-04-19 00:00:00',
        ]);

        AdminUser::create([
            'user_id' => 2,
        ]);

        AdminUser::create([
            'user_id' => 3,
        ]);

        AdminUser::create([
            'user_id' => 4,
        ]);
    }
}
