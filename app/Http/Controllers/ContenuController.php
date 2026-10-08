<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index($tri = 'recent')
    {
        return 'Liste des contenus - Tri : ' . $tri;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'Formulaire de création d’un contenu';    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return 'Enregistrement du contenu';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return 'Détail du contenu numéro ' . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return 'Détail du contenu numéro ' . $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return 'Mise à jour du contenu';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return 'Suppression du contenu';
    }
    
}
