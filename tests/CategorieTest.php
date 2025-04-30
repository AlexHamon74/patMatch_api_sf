<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class CategorieTest extends ApiTestCase
{
    // Test POST /api/categories sans authentification
    // -----------------------------------------------
    public function testPostCategorie(): void
    {
        // Données de la nouvelle catégorie à créer
        $data = [
            'nom' => 'Nouvelle catégorie',
            'description' => 'Description de la nouvelle catégorie',
        ];

        // Effectue la requête POST pour créer la catégorie
        $response = static::createClient()->request('POST', '/api/categories', [
            'json' => $data,
            'headers' => [
                'Accept' => 'application/ld+json',
                'Content-Type' => 'application/ld+json'
            ]
        ]);

        // Vérifie que le statut de la réponse est 201 Created
        $this->assertResponseStatusCodeSame(201);

        // Vérifie que la réponse contient les données de la catégorie créée
        $dataResponse = $response->toArray();
        
        $this->assertArrayHasKey('id', $dataResponse);
        $this->assertArrayHasKey('nom', $dataResponse);
        $this->assertArrayHasKey('description', $dataResponse);

        // Vérifie que la catégorie créée a bien le nom et la description attendus
        $this->assertEquals($data['nom'], $dataResponse['nom']);
        $this->assertEquals($data['description'], $dataResponse['description']);
    }


    // Test GET /api/categories
    // ------------------------
    public function testGetCategorieCollection(): void
    {
        // Test GET /api/categories sans authentification
        $response = static::createClient()->request('GET', '/api/categories', [
            'headers' => ['Accept' => 'application/ld+json']
        ]);

        // Vérifie que le statut est 200 OK
        $this->assertResponseStatusCodeSame(200); 

        // Récupère les données JSON de la réponse
        $data = $response->toArray();

        // Vérifie que la première catégorie contient les clés attendues
        $this->assertArrayHasKey('id', $data['member'][0]);
        $this->assertArrayHasKey('nom', $data['member'][0]);
        $this->assertArrayHasKey('description', $data['member'][0]);


        // Vérifie qu'on a bien 4 catégories dans le membre
        // $this->assertCount(4, $data['member']);
    }

    // Test GET /api/categories/{id}
    // -----------------------------
    public function testGetCategorieById(): void
    {
        // On crée d'abord une catégorie pour tester le GET par ID
        $data = [
            'nom' => 'Catégorie à récupérer',
            'description' => 'Description de la catégorie à récupérer',
        ];

        $responsePost = static::createClient()->request('POST', '/api/categories', [
            'json' => $data,
            'headers' => [
                'Accept' => 'application/ld+json',
                'Content-Type' => 'application/ld+json'
            ]
        ]);

        // Récupère l'ID de la catégorie nouvellement créée
        $createdCategoryData = $responsePost->toArray();
        $categoryId = $createdCategoryData['id'];

        // Effectue la requête GET pour récupérer la catégorie par son ID
        $responseGet = static::createClient()->request('GET', '/api/categories/' . $categoryId, [
            'headers' => ['Accept' => 'application/ld+json']
        ]);

        // Vérifie que le statut est 200 OK
        $this->assertResponseStatusCodeSame(200);

        // Vérifie que les données récupérées contiennent les clés attendues
        $dataResponse = $responseGet->toArray();
        $this->assertArrayHasKey('id', $dataResponse);
        $this->assertArrayHasKey('nom', $dataResponse);
        $this->assertArrayHasKey('description', $dataResponse);

        // Vérifie que les valeurs sont correctes
        $this->assertEquals($data['nom'], $dataResponse['nom']);
        $this->assertEquals($data['description'], $dataResponse['description']);
    }


    // Test DELETE /api/categories/{id} (supprimer une catégorie)
    // --------------------------------------------------------
    public function testDeleteCategorieById(): void
    {
        // On crée d'abord une catégorie pour tester le DELETE
        $data = [
            'nom' => 'Catégorie à supprimer',
            'description' => 'Description de la catégorie à supprimer',
        ];

        $responsePost = static::createClient()->request('POST', '/api/categories', [
            'json' => $data,
            'headers' => [
                'Accept' => 'application/ld+json',
                'Content-Type' => 'application/ld+json'
            ]
        ]);

        // Récupère l'ID de la catégorie nouvellement créée
        $createdCategoryData = $responsePost->toArray();
        $categoryId = $createdCategoryData['id'];

        // Effectue la requête DELETE pour supprimer la catégorie par son ID
        $responseDelete = static::createClient()->request('DELETE', '/api/categories/' . $categoryId, [
            'headers' => ['Accept' => 'application/ld+json']
        ]);

        // Vérifie que le statut est 204 No Content
        $this->assertResponseStatusCodeSame(204);

        // Effectue une requête GET pour vérifier que la catégorie a bien été supprimée
        $responseGet = static::createClient()->request('GET', '/api/categories/' . $categoryId, [
            'headers' => ['Accept' => 'application/ld+json']
        ]);

        // Vérifie que le statut est 404 Not Found
        $this->assertResponseStatusCodeSame(404);
    }
}
