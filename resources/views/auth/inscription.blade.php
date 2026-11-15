@extends('layouts.app')

@section('titre', 'Inscription — MediaHub')

@section('contenu')
    <h1>Créer un compte MediaHub</h1>

    @include('partials.erreurs')

    <form class="formulaire" method="POST" action="{{ route('inscription.store') }}">
        @csrf

        <div>
            <label for="name">Nom</label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                required
            >
            @error('name')
                <p class="erreur-champ">{{ $message }}</p>
            @enderror
        </div>

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

        <div>
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                required
            >
        </div>

        <button type="submit">Créer mon compte</button>
    </form>
@endsection
