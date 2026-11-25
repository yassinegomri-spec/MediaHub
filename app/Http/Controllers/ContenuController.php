<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Categorie;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
    $donnees = $request->safe()->except(['image','fichier_media','document_prive',]);

    if ($request->hasFile('image')) {
        $donnees['image'] = $request
            ->file('image')
            ->store('publications/images', 'public');
    }

    if ($request->hasFile('fichier_media')) {
        $fichier = $request->file('fichier_media');

        $donnees['fichier_media'] = $fichier
            ->store('publications/medias', 'public');

        $donnees['type_media'] =
            str_starts_with((string) $fichier->getMimeType(), 'audio/')
                ? 'audio'
                : 'video';
    }

    if ($request->hasFile('document_prive')) {
        $donnees['document_prive'] = $request
            ->file('document_prive')
            ->store('publications/documents', 'local');
    }

    $donnees['user_id'] = auth()->id();

    $contenu = Publication::create($donnees);

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
    $this->authorize('update', $contenu);

    $categories = Categorie::orderBy('nom')->get();

    return view('contenus.edit', compact('contenu', 'categories'));
}

public function update(
    UpdatePublicationRequest $request,
    Publication $contenu
) {
    $this->authorize('update', $contenu);

    $donnees = $request->safe()->except([
        'image',
        'fichier_media',
        'document_prive',
    ]);

    $anciensFichiers = [];

    $champsFichiers = [
        'image' => [
            'disque' => 'public',
            'dossier' => 'publications/images',
        ],
        'fichier_media' => [
            'disque' => 'public',
            'dossier' => 'publications/medias',
        ],
        'document_prive' => [
            'disque' => 'local',
            'dossier' => 'publications/documents',
        ],
    ];

    foreach ($champsFichiers as $champ => $configuration) {
        if (!$request->hasFile($champ)) {
            continue;
        }

        $anciensFichiers[$champ] = [
            'disque' => $configuration['disque'],
            'chemin' => $contenu->{$champ},
        ];

        $donnees[$champ] = $request
            ->file($champ)
            ->store(
                $configuration['dossier'],
                $configuration['disque']
            );
    }

    if ($request->hasFile('fichier_media')) {
        $mime = (string) $request
            ->file('fichier_media')
            ->getMimeType();

        $donnees['type_media'] =
            str_starts_with($mime, 'audio/')
                ? 'audio'
                : 'video';
    }

    $contenu->update($donnees);

    foreach ($anciensFichiers as $ancien) {
        if ($ancien['chemin']) {
            Storage::disk($ancien['disque'])
                ->delete($ancien['chemin']);
        }
    }

    return redirect()
        ->route('contenus.show', $contenu)
        ->with('succes', 'Publication mise à jour avec succès.');
}


public function destroy(Publication $contenu)
{
    $this->authorize('delete', $contenu);

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
    
    public function documentPrive(Publication $contenu)
{
    $this->authorize('viewPrivateDocument', $contenu);

    abort_unless(
        $contenu->document_prive
            && Storage::disk('local')->exists($contenu->document_prive),
        404
    );

    return Storage::disk('local')
        ->download($contenu->document_prive);
}

}