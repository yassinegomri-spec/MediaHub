@extends('layouts.app')

@section('titre', 'Créer une publication — MediaHub')

@section('contenu')
    <h1>Créer une publication</h1>

    @include('partials.erreurs')

    <form novalidate method="POST" action="{{ route('contenus.store') }}">
        @csrf

        <div>
            <label for="titre">Titre</label>
            <input id="titre" name="titre" type="text" value="{{ old('titre') }}" required>
            @error('titre')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="categorie_id">Catégorie</label>
            <select id="categorie_id" name="categorie_id" required>
                <option value="">Choisir une catégorie</option>
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}"
                        @selected(old('categorie_id') == $categorie->id)>
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
            <textarea id="contenu" name="contenu" rows="10" required>{{ old('contenu') }}</textarea>
            @error('contenu')
                <span class="erreur-champ">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Publier</button>
        <a href="{{ route('contenus.index') }}">Annuler</a>
    </form>
@endsection