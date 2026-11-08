<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('publications')
            ->orderBy('nom')
            ->paginate(5)
            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'slug' => $this->genererSlug($request),
        ]);

        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug'),
            ],
        ]);

        Categorie::create($donnees);

        return redirect()
            ->route('categories.index')
            ->with('succes', 'Catégorie créée avec succès.');
    }

    public function edit(Categorie $categorie)
    {
        return view('categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categorie)
    {
        $request->merge([
            'slug' => $this->genererSlug($request),
        ]);

        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($categorie->id),
            ],
        ]);

        $categorie->update($donnees);

        return redirect()
            ->route('categories.index')
            ->with('succes', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Categorie $categorie)
    {
        // Ne pas supprimer une catégorie utilisée par une publication.
        if ($categorie->publications()->withTrashed()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with(
                    'erreur',
                    'Cette catégorie est encore associée à une publication.'
                );
        }

        $categorie->delete();

        return redirect()
            ->route('categories.index')
            ->with('succes', 'Catégorie supprimée avec succès.');
    }

    private function genererSlug(Request $request): string
    {
        $valeur = $request->input('slug')
            ?: $request->input('nom', '');

        $slug = Str::slug($valeur);

        return $slug !== ''
            ? $slug
            : 'categorie-' . Str::lower(Str::random(8));
    }
}
