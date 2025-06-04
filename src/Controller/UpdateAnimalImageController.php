<?php

namespace App\Controller;

use App\Entity\Animal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

class UpdateAnimalImageController extends AbstractController
{
    public function __invoke(int $id, Request $request, EntityManagerInterface $em, UserInterface $user): JsonResponse
    {
        $animal = $em->getRepository(Animal::class)->find($id);

        if (!$animal) {
            throw new NotFoundHttpException("Animal non trouvé.");
        }

        // Vérifier si l’utilisateur connecté est bien l’éleveur de l’animal
        if ($animal->getEleveur() !== $user && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedHttpException("Vous n'avez pas le droit de modifier cet animal.");
        }

        /** @var UploadedFile $file */
        $file = $request->files->get('animalImageFile');

        if (!$file) {
            return new JsonResponse(['error' => 'Aucun fichier image envoyé'], Response::HTTP_BAD_REQUEST);
        }

        $animal->setAnimalImageFile($file);
        $animal->setMisAJourLe(new \DateTimeImmutable());
        $em->persist($animal);
        $em->flush();

        return $this->json(['message' => 'Image mise à jour avec succès'], 200);
    }
}
