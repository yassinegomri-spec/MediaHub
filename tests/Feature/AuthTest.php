<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_utilisateur_peut_sinscrire(): void
    {
        $reponse = $this->post('/inscription', [
            'name' => 'Amel',
            'email' => 'amel@exemple.com',
            'password' => 'motdepasse',
            'password_confirmation' => 'motdepasse',
        ]);

        $reponse->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'amel@exemple.com']);
    }

    public function test_connexion_avec_identifiants_incorrects(): void
    {
        $reponse = $this->post('/connexion', [
            'email' => 'inconnu@exemple.com',
            'password' => 'faux',
        ]);

        $reponse->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}