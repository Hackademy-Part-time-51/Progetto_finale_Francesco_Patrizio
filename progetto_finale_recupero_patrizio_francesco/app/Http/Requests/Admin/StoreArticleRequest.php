<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Per autorizzare l'utente

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Per ora, permettiamo a qualsiasi utente autenticato di creare un articolo.
     * In futuro potresti aggiungere logica di permessi più granulare qui.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check(); // L'utente deve essere loggato
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:articles,title',
            'content' => 'required|string|min:20',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Il titolo dell\'articolo è obbligatorio.',
            'title.unique' => 'Esiste già un articolo con questo titolo. Scegline un altro.',
            'content.required' => 'Il contenuto dell\'articolo è obbligatorio.',
            'content.min' => 'Il contenuto deve essere di almeno :min caratteri.',
            'tags.*.exists' => 'Uno o più tag selezionati non sono validi.',
        ];
    }
}