@extends('layouts.app')

@section('titre', 'Détail du contenu — MediaHub')

@section('contenu')
    <h1>{{ $contenu->titre }}</h1>

<p>
    Catégorie : {{ $contenu->categorie?->nom ?? 'Sans catégorie' }}  

    Auteur : {{ $contenu->auteur?->name ?? 'Auteur inconnu' }}
</p>

<div>
    {!! nl2br(e($contenu->contenu)) !!}
</div>

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
