<?php

namespace App\Controller;

use App\Repository\AdoptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Eleveur;

class MyAdoptionRequestsController extends AbstractController
{
    public function __invoke(UserInterface $user, AdoptionRepository $repository): JsonResponse
    {
        if (!$user instanceof Eleveur) {
            return $this->json(['error' => 'Vous devez être éleveur pour accéder à cette ressource.'], 403);
        }

        // Récupère les adoptions pour l'éleveur connecté
        $adoptions = $repository->findAdoptionsForEleveur($user);

        return $this->json($adoptions, 200, [], ['groups' => ['adoption:read'],]);
    }
}
