@extends('layouts.app')

@section('titre', 'Connexion — MediaHub')

@section('contenu')
    <h1>Connexion à MediaHub</h1>

    @include('partials.erreurs')

    <form class="formulaire" method="POST" action="{{ route('connexion.store') }}">
        @csrf

        <div>
            <label for="email">Adresse e-mail</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
            >
            @error('email')
                <p class="erreur-champ">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input
                id="password"
                name="password"
                type="password"
                required
            >
            @error('password')
                <p class="erreur-champ">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Se connecter</button>
    </form>
@endsection
