<?php

namespace Tests\Feature;

use App\Models\Categorie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorieTest extends TestCase
{
    use RefreshDatabase;

    public function test_creation_dune_categorie_par_un_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $reponse = $this->actingAs($admin)->post('/categories', [
            'nom' => 'Podcast',
            'slug' => 'podcast',
        ]);

        $reponse->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['slug' => 'podcast']);
    }

    public function test_un_auteur_ne_peut_pas_creer_une_categorie(): void
    {
        $auteur = User::factory()->create(); // rôle par défaut : auteur

        $this->actingAs($auteur)
            ->post('/categories', ['nom' => 'Test', 'slug' => 'test'])
            ->assertForbidden();

        $this->assertDatabaseMissing('categories', ['slug' => 'test']);
    }

    public function test_un_admin_peut_modifier_une_categorie(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $categorie = Categorie::factory()->create([
            'nom' => 'Ancien',
            'slug' => 'ancien',
        ]);

        $this->actingAs($admin)
            ->put("/categories/{$categorie->id}", [
                'nom' => 'Nouveau',
                'slug' => 'nouveau',
            ])
            ->assertRedirect('/categories');

        $this->assertDatabaseHas('categories', [
            'id' => $categorie->id,
            'slug' => 'nouveau',
        ]);
    }
}