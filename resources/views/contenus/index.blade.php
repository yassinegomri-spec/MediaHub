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

        {{-- Lien de création affiché selon l'état de connexion --}}
        @auth
            <p>
                <a class="bouton" href="{{ route('contenus.create') }}">
                    Créer une publication
                </a>
            </p>
        @else
            <p>
                <a class="bouton" href="{{ route('login') }}">
                    Connectez-vous pour créer une publication
                </a>
            </p>
        @endauth

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

                    <div class="actions-crud">
                        <a
                            class="lien-carte"
                            href="{{ route('contenus.show', $publication) }}"
                        >
                            Voir le contenu
                        </a>

                        @can('update', $publication)
                            <a
                                class="lien-carte"
                                href="{{ route('contenus.edit', $publication) }}"
                            >
                                Modifier
                            </a>
                        @endcan

                        @can('delete', $publication)
                            <form
                                method="POST"
                                action="{{ route('contenus.destroy', $publication) }}"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit">
                                    Supprimer
                                </button>
                            </form>
                        @endcan
                    </div>
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
