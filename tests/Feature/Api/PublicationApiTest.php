<?php

namespace Tests\Feature\Api;

use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_liste_des_publications_via_api(): void
    {
        Publication::factory()->count(5)->create();

        $this->getJson('/api/publications')
            ->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function test_creation_sans_jeton_est_refusee(): void
    {
        $this->postJson('/api/publications', [])->assertStatus(401);
    }
}