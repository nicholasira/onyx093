<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
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
            'title' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'published_date' => 'sometimes|date',
            'genre' => 'sometimes|string|in:' . implode(',', $genres),
        ];
    }
}
