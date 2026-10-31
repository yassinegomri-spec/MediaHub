@extends('layouts.app')

@section('titre', 'Contenus — MediaHub')

@section(
    'meta_description',
    'Découvrez les contenus multimédias disponibles sur MediaHub.'
)

@section('contenu')
    <section class="page-contenus">
        <div class="entete-page">
            <p class="sur-titre">MediaHub</p>

            <h1>Contenus multimédias</h1>

            <p>
                Découvrez les dernières publications disponibles.
                Tri actuel : <strong>{{ $tri }}</strong>    
            </p>
        </div>

        <div class="grille- contenus">
            @forelse ($contenus as $contenu)
                <x-carte
                    :titre="$contenu->titre"
                    :mis-en-avant="$contenu->misEnAvant ?? false"
                >
                    <p>
                        {{ $contenu->description }}
                    </p>

                    <a
                        class="lien-carte"
                        href="{{ route('contenus.show', ['contenu' => $loop->iteration]) }}"
                    >
                        Voir le contenu
                    </a>
                </x-carte>
            @empty
                <p class="message-vide">
                    Aucun contenu disponible pour le moment.
                </p>
            @endforelse
        </div>
    </section>
@endsection
