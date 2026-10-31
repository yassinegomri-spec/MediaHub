@extends('layouts.app')

@section('titre', 'Accueil — MediaHub')

@section(
    'meta_description',
    'Bienvenue sur MediaHub, plateforme de gestion de contenus multimédias.'
)

@section('contenu')
    <section class="hero">
        <p class="sur-titre">Bienvenue sur</p>

        <h1>MediaHub</h1>

        <p class="introduction">
            La plateforme de gestion et de diffusion de contenus multimédias.
        </p>

        <a class="bouton" href="{{ route('contenus.index') }}">
            Découvrir les contenus
        </a>
    </section>

    <section class="section-accueil">
        <h2>Une plateforme multimédia</h2>

        <p>
            MediaHub permet de découvrir, organiser et diffuser
            différents types de contenus multimédias.
        </p>
    </section>
@endsection
