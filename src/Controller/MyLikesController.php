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

        $likes = $repo->findBy(['client' => $user, 'type' => 'LIKE']);

        $animals = array_map(fn($swipe) => $swipe->getAnimal(), $likes);

        return $this->json($animals, 200, [], ['groups' => ['animal:read']]);
    }
}
