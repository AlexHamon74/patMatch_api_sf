<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\MyLikesController;
use App\Repository\SwipeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SwipeRepository::class)]
#[
    ApiResource(
        normalizationContext:['groups' => ['swipe:read']],
        denormalizationContext:['groups' => ['swipe:write']],
            operations: [
                new GetCollection(
                    name: 'my_likes',
                    uriTemplate: '/me/likes',
                    controller: MyLikesController::class,
                    normalizationContext: ['groups' => ['interaction:read']],
                    security: "is_granted('IS_AUTHENTICATED_FULLY')"
                ),
                new Post(security: "is_granted('IS_AUTHENTICATED_FULLY')"),
                new Delete(),
        ]
    )
]
class Swipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['swipe:read', 'swipe:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['swipe:read', 'swipe:write'])]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'swipes')]
    #[Groups(['swipe:read', 'swipe:write'])]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'swipes')]
    #[Groups(['swipe:read', 'swipe:write'])]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
