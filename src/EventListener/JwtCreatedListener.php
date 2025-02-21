<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JwtCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;


class JwtCreatedListener
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JwtCreatedEvent $event
     */
    public function onJWTCreated(JwtCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $payload = $event->getData();
        $payload['id'] = $user->getId();

        $event->setData($payload);

        $header = $event->getHeader();
        $header['cty'] = 'JWT';

        $event->setHeader($header);
    }
}