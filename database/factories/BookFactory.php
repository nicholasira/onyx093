<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genres = [
            "Fiction",
            "Non-fiction",
            "Mystery",
            "Thriller",
            "Romance",
            "Science Fiction",
            "Fantasy",
            "Horror",
            "Historical Fiction",
            "Biography",
            "Autobiography",
            "Self-help",
            "Young Adult",
            "Children's",
            "Crime",
            "Adventure",
            "Dystopian",
            "Humor",
            "Poetry",
            "Drama",
            "Classics",
            "Contemporary",
            "Literary Fiction",
            "Graphic Novel",
            "Memoir",
            "Travel",
            "True Crime",
            "Philosophy",
            "Psychology",
            "Science"
        ];

        return [
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'published_date' => $this->faker->date,
            'genre' => $this->faker->randomElement($genres),
            'publisher' => $this->faker->company,
        ];
    }
}
