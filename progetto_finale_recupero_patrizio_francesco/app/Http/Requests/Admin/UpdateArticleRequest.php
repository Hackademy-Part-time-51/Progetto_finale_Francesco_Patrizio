<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Importa la classe Rule

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // L'utente deve essere loggato e deve essere il proprietario dell'articolo
        // this->article è l'articolo passato alla rotta (route model binding)
        return Auth::check() && Auth::id() === $this->article->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('articles', 'title')->ignore($this->article->id),
            ],
            'content' => 'required|string|min:20',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('articles', 'slug')->ignore($this->article->id),
            ],
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Il titolo dell\'articolo è obbligatorio.',
            'title.unique' => 'Esiste già un altro articolo con questo titolo.',
            'content.required' => 'Il contenuto dell\'articolo è obbligatorio.',
            'content.min' => 'Il contenuto deve essere di almeno :min caratteri.',
            'tags.*.exists' => 'Uno o più tag selezionati non sono validi.',
        ];
    }
}