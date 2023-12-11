<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'adminsito',
            'lastname' => 'adminsito',
            'username' => 'admin',
            'email' => 'adminsito@admin.ad.min',
            'password' => '123',
            'birthdate' => '1999-04-19',
            'nationality_id' => 1,
            'created_at' => '2021-04-19 00:00:00',
            'updated_at' => '2021-04-19 00:00:00',
        ]);
    }
}
