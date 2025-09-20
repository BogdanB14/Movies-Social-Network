<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Gate will handle admin check
        return $this->user()?->can('movies.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required','string','max:255'],
            'year'        => ['required','integer','between:1888,2100'],
            'genre'       => ['required','string','max:120'],
            'director'    => ['required','string','max:255'],
            'description' => ['required','string','max:5000'],
            'poster'      => ['required','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'actors'      => ['nullable','array'],
            'actors.*'    => ['string','max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'actors.array'     => 'Glumci moraju biti prosleđeni kao lista.',
            'actors.*.string'  => 'Svaki glumac mora biti tekst.',
            'actors.*.max'     => 'Ime glumca može imati najviše 120 karaktera.',
        ];
    }
}
