<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Carte extends Component
{
    public function __construct(
        public string $titre,
        public bool $misEnAvant = false
    ) {
    }

    public function render(): View
    {
        return view('components.carte');
    }
}
