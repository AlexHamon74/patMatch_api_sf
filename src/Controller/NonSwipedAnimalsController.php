<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\SwipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class NonSwipedAnimalsController extends AbstractController
{
    public function __construct(
        private AnimalRepository $animalRepository,
        private SwipeRepository $swipeRepository,
        private SerializerInterface $serializer,
    ) {}

    public function __invoke(?UserInterface $user): JsonResponse
    {
        if ($user) {
            // Utilisateur connecté : filtrer les animaux déjà swipés
            $swipedAnimalIds = $this->swipeRepository->createQueryBuilder('c')
                ->select('IDENTITY(c.animal)')
                ->where('c.user = :user')
                ->setParameter('user', $user)
                ->getQuery()
                ->getSingleColumnResult();

            $animals = $this->animalRepository->createQueryBuilder('a')
                ->where('a.id NOT IN (:ids)')
                ->setParameter('ids', $swipedAnimalIds ?: [0])
                ->getQuery()
                ->getResult();
        } else {
            // Utilisateur non connecté : retourner tous les animaux
            $animals = $this->animalRepository->findAll();
        }

        $json = $this->serializer->serialize(
            $animals,
            'json',
            ['groups' => ['animal:read']]
        );

        return new JsonResponse($json, 200, [], true);
    }
}
