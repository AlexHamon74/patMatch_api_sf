<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\SwipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

class MyLikesController extends AbstractController
{
    public function __invoke(UserInterface $user, SwipeRepository $repo): JsonResponse {

        if (!$user instanceof Client) {
            return $this->json(['error' => 'User is not a client'], 403);
        }

        // Récupère les swipes de type LIKE pour ce client
        $likes = $repo->findBy(['client' => $user, 'type' => 'LIKE']);

        // Retourne directement les entités Swipe, avec leur groupe de normalisation
        return $this->json($likes, 200, [], ['groups' => ['swipe:read']]);
    }
}
