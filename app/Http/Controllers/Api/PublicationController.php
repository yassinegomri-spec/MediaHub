<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    public function index(Request $request)
    {
        $requete = Publication::with(['categorie', 'auteur'])->latest();

        if ($categorieId = $request->integer('categorie_id')) {
            $requete->where('categorie_id', $categorieId);
        }

        return PublicationResource::collection($requete->paginate(10));
    }

    public function show(Publication $publication)
    {
        return new PublicationResource(
            $publication->load(['categorie', 'auteur'])
        );
    }

    public function store(StorePublicationRequest $request)
    {
        $donnees = $request->safe()->except(['image', 'fichier_media']);

        if ($request->hasFile('image')) {
            $donnees['image'] = $request->file('image')
                ->store('publications/images', 'public');
        }

        if ($request->hasFile('fichier_media')) {
            $fichier = $request->file('fichier_media');

            $donnees['fichier_media'] = $fichier
                ->store('publications/medias', 'public');

            $donnees['type_media'] = str_starts_with(
                (string) $fichier->getMimeType(),
                'audio/'
            ) ? 'audio' : 'video';
        }

        $donnees['user_id'] = $request->user()->id;

        $publication = Publication::create($donnees);

        return (new PublicationResource(
            $publication->load(['categorie', 'auteur'])
        ))->response()->setStatusCode(201);
    }

    public function update(
        UpdatePublicationRequest $request,
        Publication $publication
    ) {
        $this->authorize('update', $publication);

        $donnees = $request->safe()->except(['image', 'fichier_media']);
        $anciensFichiers = [];

        $champsFichiers = [
            'image' => ['disque' => 'public', 'dossier' => 'publications/images'],
            'fichier_media' => ['disque' => 'public', 'dossier' => 'publications/medias'],
        ];

        foreach ($champsFichiers as $champ => $configuration) {
            if (! $request->hasFile($champ)) {
                continue;
            }

            if ($publication->{$champ}) {
                $anciensFichiers[] = [
                    'disque' => $configuration['disque'],
                    'chemin' => $publication->{$champ},
                ];
            }

            $donnees[$champ] = $request
                ->file($champ)
                ->store($configuration['dossier'], $configuration['disque']);
        }

        if ($request->hasFile('fichier_media')) {
            $mime = (string) $request->file('fichier_media')->getMimeType();

            $donnees['type_media'] = str_starts_with($mime, 'audio/')
                ? 'audio'
                : 'video';
        }

        $publication->update($donnees);

        foreach ($anciensFichiers as $ancien) {
            Storage::disk($ancien['disque'])->delete($ancien['chemin']);
        }

        return new PublicationResource(
            $publication->load(['categorie', 'auteur'])
        );
    }

    public function destroy(Publication $publication)
    {
        $this->authorize('delete', $publication);

        $publication->forceDelete();

        return response()->json(null, 204);
    }
}