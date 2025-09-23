<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);

        return [
            'title'       => $title,
            'director'    => $this->faker->name(),
            'year'        => $this->faker->numberBetween(1950, (int) now()->year),
            'genre'       => $this->faker->randomElement(['Drama','Comedy','Action','Thriller','Sci-Fi','Romance']),
            'description' => $this->faker->paragraphs(2, true),
            'actors'      => $this->faker->randomElements(
                array_map(fn() => $this->faker->name(), range(1, 8)),
                $this->faker->numberBetween(3, 5)
            ),
            'poster'      => $this->faker->imageUrl(600, 900, 'movie', true, 'Poster'),
        ];
    }
}
