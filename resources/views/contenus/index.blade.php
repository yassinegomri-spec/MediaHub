@extends('layouts.app')

@section('titre', 'Contenus — MediaHub')

@section('meta_description', 'Découvrez les contenus multimédias disponibles sur MediaHub.')

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

        <div class="grille-contenus">
            @forelse ($publications as $publication)
                <x-carte :titre="$publication->titre">
                    <p>
                        {{ \Illuminate\Support\Str::limit($publication->contenu, 180) }}
                    </p>

                    <p>
                        Catégorie :
                        {{ $publication->categorie?->nom ?? 'Sans catégorie' }}  


                        Auteur :
                        {{ $publication->auteur?->name ?? 'Auteur inconnu' }}  


                        Commentaires :
                        {{ $publication->commentaires_count }}
                    </p>

                    <a
                        class="lien-carte"
                        href="{{ route('contenus.show', $publication) }}"
                    >
                        Voir le contenu
                    </a>
                </x-carte>
            @empty
                <p class="message-vide">
                    Aucune publication disponible pour le moment.
                </p>
            @endforelse
        </div>

        {{ $publications->links() }}
    </section>
@endsection
