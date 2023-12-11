<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RegisteredUser;

class RegisteredUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(20)->create();
        RegisteredUser::factory()->count(20)->userId(4, 24)->create();
    }
}
