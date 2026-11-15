<nav class="navigation">
    <div class="navigation-interne">
        <a class="logo" href="{{ route('accueil') }}">
            MediaHub
        </a>

        <div class="liens-navigation">
            <a href="{{ route('accueil') }}">
                Accueil
            </a>

            <a href="{{ route('contenus.index') }}">
                Contenus
            </a>

            <a href="{{ route('a-propos') }}">
                À propos
            </a>
            @guest
                <a href="{{ route('login') }}">Connexion</a>
                <a href="{{ route('inscription') }}">Inscription</a>
            @endguest

            @auth
                <form method="POST" action="{{ route('deconnexion') }}">
             @csrf
                <button type="submit">Déconnexion</button>
                </form>
@endauth

        </div>
    </div>
</nav>
