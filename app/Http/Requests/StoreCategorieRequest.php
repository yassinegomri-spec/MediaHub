<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreCategorieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Génère le slug depuis le nom si le champ est vide
    protected function prepareForValidation(): void
    {
        $valeur = $this->input('slug') ?: $this->input('nom', '');
        $slug = Str::slug((string) $valeur);

        $this->merge([
            'slug' => $slug !== ''
                ? $slug
                : 'categorie-' . Str::lower(Str::random(8)),
        ]);
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'slug' => [
                'required', 'string', 'max:255',
                Rule::unique('categories', 'slug'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de la catégorie est obligatoire.',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'slug.required' => 'Le slug est obligatoire.',
            'slug.max' => 'Le slug ne doit pas dépasser 255 caractères.',
            'slug.unique' => 'Ce slug est déjà utilisé par une autre catégorie.',
        ];
    }
}