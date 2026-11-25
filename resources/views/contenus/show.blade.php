@extends('layouts.app')

@section('titre', 'Détail du contenu — MediaHub')

@section('contenu')
    <h1>{{ $contenu->titre }}</h1>

    <p>
        Catégorie : {{ $contenu->categorie?->nom ?? 'Sans catégorie' }}
        Auteur : {{ $contenu->auteur?->name ?? 'Auteur inconnu' }}
    </p>

    <div style="white-space: pre-line;">{{ $contenu->contenu }}</div>

    @if ($contenu->image)
        <figure>
            <img
                src="{{ $contenu->url_image }}"
                alt="{{ $contenu->titre }}"
                style="max-width: 100%; height: auto"
            >
        </figure>
    @endif

    @if ($contenu->type_media === 'audio')
        <audio
            controls
            src="{{ \Illuminate\Support\Facades\Storage::url($contenu->fichier_media) }}"
        >
            Votre navigateur ne prend pas en charge la lecture audio.
        </audio>
    @elseif ($contenu->type_media === 'video')
        <video
            controls
            style="max-width: 100%"
            src="{{ \Illuminate\Support\Facades\Storage::url($contenu->fichier_media) }}"
        >
            Votre navigateur ne prend pas en charge la lecture vidéo.
        </video>
    @endif

    <h2>Commentaires ({{ $contenu->commentaires->count() }})</h2>

    @forelse ($contenu->commentaires as $commentaire)
        <article>
            <p>
                <strong>{{ $commentaire->auteur?->name ?? 'Auteur inconnu' }}</strong>
            </p>
            <p>{{ $commentaire->contenu }}</p>
        </article>
    @empty
        <p>Aucun commentaire pour le moment.</p>
    @endforelse
@endsection
