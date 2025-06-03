<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\MyAdoptionRequestsController;
use App\Enum\AdoptionStatus;
use App\Repository\AdoptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AdoptionRepository::class)]
#[
    ApiResource(
        normalizationContext:['groups' => ['adoption:read']],
        denormalizationContext: ['groups' => ['adoption:write']],
        operations: [
            new GetCollection(
                name: 'my_adoptions',
                uriTemplate: '/me/adoptionRequests',
                controller: MyAdoptionRequestsController::class,
                security: "is_granted('ROLE_ELEVEUR')",
                normalizationContext: ['groups' => ['adoption:read']],
                read: false
            ),
            new Post(security: "is_granted('ROLE_CLIENT')"),
            new Patch(security: "is_granted('ROLE_ELEVEUR')"),
            new Delete()
        ]
    ),
]
class Adoption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['adoption:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'adoptions')]
    #[Groups(['adoption:write', 'adoption:read'])]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'adoptions')]
    #[Groups(['adoption:write', 'client:read', 'adoption:read'])]
    private ?Animal $animal = null;

    #[ORM\Column(enumType: AdoptionStatus::class)]
    #[Groups(['adoption:write', 'client:read', 'adoption:read'])]
    private ?AdoptionStatus $status = null;

    #[ORM\Column]
    #[Groups(['adoption:write', 'client:read', 'adoption:read'])]
    private ?\DateTimeImmutable $dateDemande = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getStatus(): ?AdoptionStatus
    {
        return $this->status;
    }

    public function setStatus(AdoptionStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateDateDemande(): void
    {
        $this->dateDemande = new \DateTimeImmutable();
    }

    public function getDateDemande(): ?\DateTimeImmutable
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeImmutable $dateDemande): static
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }
}
