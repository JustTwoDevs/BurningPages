<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            NationalitySeeder::class,
            AuthorSeeder::class,
            BookSeeder::class,
            AdminSeeder::class,
            AdminUserSeeder::class,
            RegisteredUserSeeder::class,
            GenreSeeder::class,
            BookGenresSeeder::class,
            BookWritersSeeder::class,
            BookSagasSeeder::class,
            BookCollectionsSeeder::class,
            ReviewSeeder::class,
            BookReviewSeeder::class,
            BookSagaReviewSeeder::class,
            ReviewRateSeeder::class,
            BookReviewRateSeeder::class,
            SagaReviewRateSeeder::class,
            BackingRequestSeeder::class,
        ]);
    }
}
