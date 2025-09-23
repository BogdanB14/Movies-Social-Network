<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        $first = $this->faker->firstName();
        $last  = $this->faker->lastName();

        return [
            'name'       => $first,
            'last_name'  => $last,
            'email'      => $this->faker->unique()->safeEmail(),
            'username'   => Str::lower($first) . '.' . Str::lower($last) . $this->faker->numberBetween(1, 999),
            'password'   => Hash::make('password'), // default: password
            'role'       => $this->faker->randomElement(['user','admin']),
        ];
    }
}
