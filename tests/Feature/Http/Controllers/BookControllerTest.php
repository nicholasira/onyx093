<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test to fetch all books.
     */
    public function test_fetch_all_books(): void
    {
        $books = Book::factory()->count(10)->create();

        $response = $this->getJson(route('books.index'));

        $response->assertOk();
    }

    /**
     * A basic feature test to fetch a collection of paginated books.
     *
     * @return void
     */
    public function test_fetch_collection_of_paginated_books(): void
    {
        $books = Book::factory()->count(30)->create();

        $response = $this->getJson(route('books.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'status_code',
                'message',
                'data' => [
                    'data' => [
                       '*' => ['id', 'title', 'created_at', 'updated_at']
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total'
                ],
            ]);
    }

    /**
     * A basic feature test to fetch a book.
     */
    public function test_fetch_a_book(): void
    {
        $book = Book::factory()->createOne();

        $response = $this->getJson(route('books.show', $book->id));

        $response->assertOk()->assertJsonStructure([
            'status_code',
            'message',
            'data' => [
                'id',
                'title',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /**
     * A basic feature test to check if a book doesn't exist.
     */
    public function test_should_an_error_when_fetching_a_book_that_does_not_exist(): void
    {
        Book::factory()->createOne();
        $uuid = Str::uuid();

        $response = $this->getJson(route('books.show', $uuid));

        $response->assertNotFound();

        $this->assertDatabaseMissing('books', [
            'id' => $uuid,
        ]);
    }

    /**
     * A basic feature test to store a book.
     */
    public function test_book_can_be_stored(): void
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

        $newBook = [
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'published_date' => $this->faker->date,
            'genre' => $this->faker->randomElement($genres),
            'publisher' => $this->faker->company,
        ];
        $title = 'foobar';

        $response = $this->postJson(route('books.store'), $newBook);

        $response->assertCreated()->assertJsonIsObject()->assertJsonStructure(
            [
                'status_code',
                'message',
                'data' => [
                    'id',
                    'title',
                    'created_at',
                    'updated_at',
                ]
            ]
        );
        $books = Book::all();
        $this->assertCount(1, $books);
    }

    /**
     * A basic feature test to check for required values while creating a book.
     */
    public function test_throw_error_if_required_values_are_not_provided(): void
    {

        $response = $this->postJson(route('books.store'));

        $response->assertUnprocessable()->assertJsonStructure(
            [
                'message',
                'errors',
            ]
        );
    }

    /**
     * A basic feature test to check if error 404 found is thrown if book to update doesn't exist.
     *
     * @return void
     */
    public function test_will_fail_with_a_404_if_book_to_be_updated_is_not_found(): void
    {
        $book = Book::factory()->createOne();
        $uuid = Str::uuid();
        $response = $this->deleteJson(route('books.update', $uuid));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $this->assertDatabaseMissing('books', [
            'id' => $uuid,
        ]);
    }

    /**
     * A basic feature test to delete a book.
     */
    public function test_delete_a_book(): void
    {
        $book = Book::factory()->createOne();
        $response = $this->deleteJson(route('books.destroy', $book->id));

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
            'title' => $book->title,
        ]);
    }

    /**
     * A basic feature test to check if error 404 found is thrown if book to delete doesn't exist.
     *
     * @return void
     */
    public function test_will_fail_with_a_404_if_book_to_be_deleted_is_not_found(): void
    {
        $book = Book::factory()->createOne();
        $uuid = Str::uuid();
        $response = $this->deleteJson(route('books.destroy', $uuid));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $this->assertDatabaseMissing('books', [
            'id' => $uuid,
        ]);
    }
}
