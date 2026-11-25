<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_liste_des_publications_est_accessible(): void
    {
        Publication::factory()->count(3)->create();

        $this->get('/contenus')
            ->assertStatus(200)
            ->assertSeeText('Contenus multimédias');
    }

    public function test_un_visiteur_ne_peut_pas_creer_de_publication(): void
    {
        $this->post('/contenus', [])->assertRedirect('/connexion');
    }

    public function test_un_auteur_peut_modifier_sa_propre_publication(): void
    {
        $auteur = User::factory()->create();
        $publication = Publication::factory()->create(['user_id' => $auteur->id]);

        $this->actingAs($auteur)
            ->put("/contenus/{$publication->id}", [
                'titre' => 'Titre modifié',
                'contenu' => str_repeat('a', 30),
                'categorie_id' => $publication->categorie_id,
            ])
            ->assertRedirect("/contenus/{$publication->id}");
    }

    public function test_un_auteur_ne_peut_pas_modifier_une_autre_publication(): void
    {
        $auteur = User::factory()->create();
        $publication = Publication::factory()->create();

        $this->actingAs($auteur)
            ->put("/contenus/{$publication->id}", [
                'titre' => 'Tentative de modification',
                'contenu' => str_repeat('a', 30),
                'categorie_id' => $publication->categorie_id,
            ])
            ->assertForbidden();
    }
}