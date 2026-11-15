@extends('layouts.app')

@section('titre', 'Modifier une catégorie — MediaHub')

@section('contenu')
    <h1>Modifier la catégorie</h1>

    @include('partials.erreurs')

    <form novalidate method="POST" action="{{ route('categories.update', $categorie) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="nom">Nom</label>
            <input id="nom" name="nom" type="text"
                   value="{{ old('nom', $categorie->nom) }}" required>
            @error('nom')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="slug">Slug</label>
            <input id="slug" name="slug" type="text"
                   value="{{ old('slug', $categorie->slug) }}">
            @error('slug')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Enregistrer</button>
        <a href="{{ route('categories.index') }}">Annuler</a>
    </form>
@endsection