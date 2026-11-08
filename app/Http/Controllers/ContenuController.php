<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ContenuController extends Controller
{
    public function index(?string $tri = 'recent')
    {
        $requete = Publication::query()
            ->with(['categorie', 'auteur'])
            ->withCount('commentaires');

        if ($tri === 'ancien') {
            $requete->oldest();
        } elseif ($tri === 'titre') {
            $requete->orderBy('titre');
        } else {
            $tri = 'recent';
            $requete->latest();
        }

        $publications = $requete
            ->paginate(9)
            ->withQueryString();

        return view('contenus.index', compact('publications', 'tri'));
    }

    public function create()
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('contenus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $donnees = $request->validate([
            'titre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('publications', 'titre'),
            ],
            'contenu' => ['required', 'string'],
            'categorie_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],
        ]);

        $donnees['user_id'] = Auth::id()
            ?? $this->auteurDeDemonstration()->id;

        $contenu = Publication::create($donnees);

        return redirect()
            ->route('contenus.show', $contenu)
            ->with('succes', 'Publication créée avec succès.');
    }

    public function show(Publication $contenu)
    {
        $contenu->load([
            'categorie',
            'auteur',
            'commentaires.auteur',
        ]);

        return view('contenus.show', compact('contenu'));
    }

    public function edit(Publication $contenu)
    {
        $categories = Categorie::orderBy('nom')->get();

        return view(
            'contenus.edit',
            compact('contenu', 'categories')
        );
    }

    public function update(Request $request, Publication $contenu)
    {
        $donnees = $request->validate([
            'titre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('publications', 'titre')
                    ->ignore($contenu->id),
            ],
            'contenu' => ['required', 'string'],
            'categorie_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],
        ]);

        $contenu->update($donnees);

        return redirect()
            ->route('contenus.show', $contenu)
            ->with('succes', 'Publication mise à jour avec succès.');
    }

    public function destroy(Publication $contenu)
    {
        $contenu->delete();

        return redirect()
            ->route('contenus.index')
            ->with('succes', 'Publication supprimée avec succès.');
    }

    private function auteurDeDemonstration(): User
    {
        $auteur = User::query()->first();

        if ($auteur) {
            return $auteur;
        }

        // Auteur provisoire avant l’ajout de l’authentification en semaine 8.
        return User::query()->create([
            'name' => 'Auteur de démonstration',
            'email' => 'demo@mediahub.test',
            'password' => Str::random(48),
        ]);
    }
}
