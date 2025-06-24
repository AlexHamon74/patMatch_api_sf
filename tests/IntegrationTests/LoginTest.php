<?php

namespace App\Tests\Auth;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class LoginTest extends ApiTestCase
{
    // Cas 1 : Identifiants valides → token JWT
    public function testLoginCheckReturnsJwtToken(): void
    {
        $client = static::createClient();

        $response = $client->request('POST', '/api/login_check', [
            'json' => [
                'username' => 'leo@client.com',
                'password' => 'test123',
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);

        $data = $response->toArray();
        $this->assertArrayHasKey('token', $data);
        $this->assertNotEmpty($data['token']);
    }

    // Cas 2 : Mauvais mot de passe → erreur 401
    public function testLoginWithWrongPasswordFails(): void
    {
        $client = static::createClient();

        $response = $client->request('POST', '/api/login_check', [
            'json' => [
                'username' => 'leo@client.com',
                'password' => 'test1234', // Mauvais mot de passe
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);

        $this->assertResponseStatusCodeSame(401);

        $data = $response->toArray(false);
        $this->assertArrayHasKey('message', $data);
        $this->assertSame('Identifiants invalides.', $data['message']);
    }
}
