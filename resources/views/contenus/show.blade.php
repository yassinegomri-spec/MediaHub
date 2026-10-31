@extends('layouts.app')

@section('titre', 'Détail du contenu — MediaHub')

@section('contenu')
    <section class="page-simple">
        <p class="sur-titre">Contenu multimédia</p>

        <h1>
            Détail du contenu numéro {{ $id }}
        </h1>

        <p>
            Cette page présente le détail d'un contenu multimédia.
        </p>

        <a class="bouton" href="{{ route('contenus.index') }}">
            Retour aux contenus
        </a>
    </section>
@endsection
