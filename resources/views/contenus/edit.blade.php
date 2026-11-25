@extends('layouts.app')

@section('titre', 'Modifier une publication — MediaHub')

@section('contenu')
    <h1>Modifier la publication</h1>

    @include('partials.erreurs')

    <form
        novalidate
        method="POST"
        action="{{ route('contenus.update', $contenu) }}"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="titre">Titre</label>
            <input
                id="titre"
                name="titre"
                type="text"
                value="{{ old('titre', $contenu->titre) }}"
                required
            >
            @error('titre')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="categorie_id">Catégorie</label>
            <select id="categorie_id" name="categorie_id" required>
                <option value="">Choisir une catégorie</option>
                @foreach ($categories as $categorie)
                    <option
                        value="{{ $categorie->id }}"
                        @selected(old('categorie_id', $contenu->categorie_id) == $categorie->id)
                    >
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
            @error('categorie_id')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="contenu">Contenu</label>
            <textarea
                id="contenu"
                name="contenu"
                rows="10"
                required
            >{{ old('contenu', $contenu->contenu) }}</textarea>
            @error('contenu')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        @if ($contenu->image)
            <p>
                Image actuelle :
                <img
                    src="{{ $contenu->url_image }}"
                    alt="{{ $contenu->titre }}"
                    style="max-width: 180px"
                >
            </p>
        @endif

        @if ($contenu->type_media)
            <p>Média actuel : {{ $contenu->type_media }}</p>
        @endif

        <div>
            <label for="image">Nouvelle image — 2 Mo maximum</label>
            <input
                id="image"
                name="image"
                type="file"
                accept="image/*"
            >
            @error('image')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="fichier_media">Nouveau fichier audio ou vidéo — 20 Mo maximum</label>
            <input
                id="fichier_media"
                name="fichier_media"
                type="file"
                accept="audio/*,video/*"
            >
            @error('fichier_media')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Enregistrer</button>
        <a href="{{ route('contenus.show', $contenu) }}">Annuler</a>
    </form>
@endsection
