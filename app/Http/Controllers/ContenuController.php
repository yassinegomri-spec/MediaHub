<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

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
        return 'Formulaire de création d’un contenu';
    }

    public function store(Request $request)
    {
        return 'Enregistrement du contenu';
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


    public function edit(string $id)
    {
        return 'Formulaire de modification du contenu numéro ' . $id;
    }

    public function update(Request $request, string $id)
    {
        return 'Mise à jour du contenu numéro ' . $id;
    }

    public function destroy(string $id)
    {
        return 'Suppression du contenu numéro ' . $id;
    }
}
