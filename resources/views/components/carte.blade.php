<article class="carte {{ $misEnAvant ? 'carte-mise-en-avant' : '' }}">
    @if ($misEnAvant)
        <span class="badge">
            À la une
        </span>
    @endif

    <h2>{{ $titre }}</h2>

    <div class="carte-corps">
        {{ $slot }}
    </div>
</article>
