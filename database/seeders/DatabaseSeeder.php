<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Movie;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'      => 'Admin',
                'last_name' => 'User',
                'username'  => 'admin',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
            ]
        );

        $users  = User::factory(9)->create();
        $movies = Movie::factory(15)->create();

        foreach ($movies as $movie) {
            $commenters = User::inRandomOrder()->take(fake()->numberBetween(2, 6))->get();

            foreach ($commenters as $user) {
                Comment::factory(fake()->numberBetween(1, 3))
                    ->for($user, 'user')
                    ->for($movie, 'movie')
                    ->create();
            }
        }
    }
}
