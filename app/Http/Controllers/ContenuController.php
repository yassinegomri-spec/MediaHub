<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContenuController extends Controller
{
    public function index(?string $tri = 'recent')
    {
        $contenus = [
            (object) [
                'titre' => 'Court-métrage documentaire',
                'description' => 'Un aperçu de la vie urbaine.',
                'misEnAvant' => true,
            ],

            (object) [
                'titre' => 'Podcast technologie',
                'description' => 'Actualités du développement web.',
                'misEnAvant' => false,
            ],

            (object) [
                'titre' => 'Galerie photographique',
                'description' => 'Une collection de photographies contemporaines.',
                'misEnAvant' => false,
            ],
        ];

        return view('contenus.index', [
            'contenus' => $contenus,
            'tri' => $tri,
        ]);
    }

    public function create()
    {
        return 'Formulaire de création d’un contenu';
    }

    public function store(Request $request)
    {
        return 'Enregistrement du contenu';
    }

    public function show(string $id)
    {
        return view('contenus.show', [
            'id' => $id,
        ]);
    }

    public function edit(string $id)
    {
        return 'Formulaire de modification du contenu numéro ' . $id;
    }

    public function update(Request $request, string $id)
    {
        return 'Mise à jour du contenu numéro ' . $id;
    }

    public function destroy(string $id)
    {
        return 'Suppression du contenu numéro ' . $id;
    }
}
