<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titre', 'MediaHub')</title>

    <meta
        name="description"
        content="@yield('meta_description', 'MediaHub, plateforme de contenus multimédias')"
    >

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    @include('partials.navigation')

    <main class="conteneur">
        @if (session('succes'))
    <div class="alerte alerte-succes">
        {{ session('succes') }}
    </div>
    @endif

    @if (session('erreur'))
    <div class="alerte alerte-erreur">
        {{ session('erreur') }}
    </div>
    @endif

    @yield('contenu')

    @include('partials.pied-de-page')

</body>
</html>
