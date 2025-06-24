<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class CategorieTest extends ApiTestCase
{
    // Test que les routes de la classe Categorie fonctionnent
    public function testFullCategorieLifecycle(): void
    {
        $client = static::createClient();

        // 1. CREATE
        $data = [
            'nom' => 'Catégorie de test',
            'description' => 'Description de test',
        ];

        $response = $client->request('POST', '/api/categories', [
            'json' => $data,
            'headers' => [
                'Accept' => 'application/ld+json',
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);

        $created = $response->toArray();
        $this->assertArrayHasKey('id', $created);
        $categoryId = $created['id'];

        // 2. GET COLLECTION
        $response = $client->request('GET', '/api/categories', [
            'headers' => ['Accept' => 'application/ld+json'],
        ]);
        $this->assertResponseStatusCodeSame(200);
        $list = $response->toArray();

        $this->assertNotEmpty($list['member']);

        $found = array_filter($list['member'], fn($item) => $item['id'] === $categoryId);
        $this->assertNotEmpty($found);

        // 3. GET BY ID
        $response = $client->request('GET', '/api/categories/' . $categoryId, [
            'headers' => ['Accept' => 'application/ld+json'],
        ]);
        $this->assertResponseStatusCodeSame(200);
        $fetched = $response->toArray();
        $this->assertEquals($data['nom'], $fetched['nom']);
        $this->assertEquals($data['description'], $fetched['description']);

        // 4. PATCH
        $updatedData = [
            'nom' => 'Catégorie mise à jour',
        ];

        $response = $client->request('PATCH', '/api/categories/' . $categoryId, [
            'json' => $updatedData,
            'headers' => [
                'Accept' => 'application/ld+json',
                'Content-Type' => 'application/merge-patch+json',
            ],
        ]);
        $this->assertResponseStatusCodeSame(200);

        $patched = $response->toArray();
        $this->assertEquals($updatedData['nom'], $patched['nom']); // modifiée
        $this->assertEquals($data['description'], $patched['description']); // non modifiée

        // 5. DELETE
        $client->request('DELETE', '/api/categories/' . $categoryId, [
            'headers' => ['Accept' => 'application/ld+json'],
        ]);
        $this->assertResponseStatusCodeSame(204);
    }
}
