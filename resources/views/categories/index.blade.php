@extends('layouts.app')

@section('titre', 'Catégories — MediaHub')

@section('contenu')
    <h1>Catégories</h1>

    <p>
        <a href="{{ route('categories.create') }}">Créer une catégorie</a>
    </p>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Slug</th>
                <th>Publications</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($categories as $categorie)
                <tr>
                    <td>{{ $categorie->nom }}</td>
                    <td>{{ $categorie->slug }}</td>
                    <td>{{ $categorie->publications_count }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $categorie) }}">
                            Modifier
                        </a>

                        <form
                            method="POST"
                            action="{{ route('categories.destroy', $categorie) }}"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Aucune catégorie pour le moment.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    
