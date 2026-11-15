<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Categorie;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        $publications = $requete->paginate(9)->withQueryString();

        return view('contenus.index', compact('publications', 'tri'));
    }

    public function create()
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('contenus.create', compact('categories'));
    }

    public function store(StorePublicationRequest $request)
{
    $contenu = new Publication($request->validated());

    $contenu->user_id = Auth::id()
        ?? $this->auteurDeDemonstration()->id;

    $contenu->save();

    return redirect()
        ->route('contenus.show', $contenu)
        ->with('succes', 'Publication créée avec succès.');
}

    public function show(Publication $contenu)
    {
        $contenu->load(['categorie', 'auteur', 'commentaires.auteur']);

        return view('contenus.show', compact('contenu'));
    }

    public function edit(Publication $contenu)
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('contenus.edit', compact('contenu', 'categories'));
    }

    public function update(UpdatePublicationRequest $request, Publication $contenu)
    {
        $contenu->update($request->validated());

        return redirect()
            ->route('contenus.show', $contenu)
            ->with('succes', 'Publication mise à jour avec succès.');
    }

    public function destroy(Publication $contenu)
{
    $contenu->forceDelete();

    return redirect()
        ->route('contenus.index')
        ->with('succes', 'Publication supprimée définitivement.');
}


    private function auteurDeDemonstration(): User
    {
        $auteur = User::query()->first();

        if ($auteur) {
            return $auteur;
        }

        // Auteur provisoire avant l'authentification (semaine 8).
        return User::query()->create([
            'name' => 'Auteur de démonstration',
            'email' => 'demo@mediahub.test',
            'password' => Str::random(48),
        ]);
    }
}