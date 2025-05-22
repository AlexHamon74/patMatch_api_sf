<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Eleveur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

class MeController extends AbstractController
{
    public function __invoke(UserInterface $user): JsonResponse
    {
        if ($user instanceof Client) {
            $groups[] = 'client:read';
        }

        elseif ($user instanceof Eleveur) {
            $groups[] = 'eleveur:read';
        }

        elseif ($user instanceof UserInterface) {
            $groups[] = 'user:read';
        }

        else {
            throw new \Exception('User type not recognized');
        }

        return $this->json($user, 200, [], ['groups' => $groups]);
    }
}
