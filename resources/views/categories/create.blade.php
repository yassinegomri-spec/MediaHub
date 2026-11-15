@extends('layouts.app')

@section('titre', 'Créer une catégorie — MediaHub')

@section('contenu')
    <h1>Créer une catégorie</h1>

    @include('partials.erreurs')

    <form novalidate method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div>
            <label for="nom">Nom</label>
            <input id="nom" name="nom" type="text" value="{{ old('nom') }}" required>
            @error('nom')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="slug">Slug</label>
            <input id="slug" name="slug" type="text" value="{{ old('slug') }}"
                   placeholder="Généré depuis le nom si laissé vide">
            @error('slug')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Créer</button>
        <a href="{{ route('categories.index') }}">Annuler</a>
    </form>
@endsection