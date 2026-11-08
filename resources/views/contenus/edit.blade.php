@extends('layouts.app')

@section('titre', 'Modifier une publication — MediaHub')

@section('contenu')
    <h1>Modifier la publication</h1>

    <form
        method="POST"
        action="{{ route('contenus.update', $contenu) }}"
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
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="categorie_id">Catégorie</label>
            <select id="categorie_id" name="categorie_id" required>
                <option value="">Choisir une catégorie</option>
                @foreach ($categories as $categorie)
                    <option
                        value="{{ $categorie->id }}"
                        @selected(
                            old('categorie_id', $contenu->categorie_id)
                            == $categorie->id
                        )
                    >
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
            @error('categorie_id')
                <p>{{ $message }}</p>
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
                <p>{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Enregistrer</button>
        <a href="{{ route('contenus.show', $contenu) }}">Annuler</a>
    </form>
@endsection
