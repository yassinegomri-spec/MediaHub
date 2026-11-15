<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePublicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre' => [
                'required', 'string', 'min:10', 'max:255',
                Rule::unique('publications', 'titre'),
            ],
            'contenu' => ['required', 'string', 'min:20'],
            'categorie_id' => [
                'required', 'integer',
                Rule::exists('categories', 'id'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.min' => 'Le titre doit contenir au moins 10 caractères.',
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'titre.unique' => 'Une publication porte déjà ce titre.',
            'contenu.required' => 'Le contenu est obligatoire.',
            'contenu.min' => 'Le contenu doit contenir au moins 20 caractères.',
            'categorie_id.required' => 'Veuillez choisir une catégorie.',
            'categorie_id.integer' => 'La catégorie choisie est invalide.',
            'categorie_id.exists' => 'La catégorie choisie n\'existe pas.',
        ];
    }
}