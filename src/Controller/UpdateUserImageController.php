<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateUserImageController extends AbstractController
{
    public function __invoke(int $id, Request $request, EntityManagerInterface $em, ?UserInterface $user = null): JsonResponse
    {
        $userToUpdate = $em->getRepository(User::class)->find($id);

        if (!$userToUpdate) {
            throw new NotFoundHttpException("Utilisateur non trouvé.");
        }

        // Facultatif : restreindre les droits si un utilisateur est connecté
        if ($user && $user !== $userToUpdate && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedHttpException("Vous n'avez pas le droit de modifier cet utilisateur.");
        }

        /** @var UploadedFile $file */
        $file = $request->files->get('photoProfilFile');

        if (!$file) {
            return new JsonResponse(['error' => 'Aucun fichier image envoyé'], Response::HTTP_BAD_REQUEST);
        }

        $userToUpdate->setPhotoProfilFile($file);
        $userToUpdate->setMisAJourLe(new \DateTimeImmutable());
        $em->persist($userToUpdate);
        $em->flush();

        return $this->json(['message' => 'Image utilisateur mise à jour avec succès'], 200);
    }
}
