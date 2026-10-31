@extends('layouts.app')

@section('titre', 'À propos — MediaHub')

@section(
    'meta_description',
    'Découvrez le projet MediaHub et ses objectifs.'
)

@section('contenu')
    <section class="page-simple">
        <p class="sur-titre">MediaHub</p>

        <h1>À propos de MediaHub</h1>

        <p>
            MediaHub est une plateforme de gestion et de diffusion
            de contenus multimédias.
        </p>

        <p>
            Ce projet est développé dans le cadre du module Laravel
            pour mettre en pratique les routes, contrôleurs et vues Blade.
        </p>
    </section>
@endsection
