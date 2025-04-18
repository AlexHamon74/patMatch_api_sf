<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CorrespondanceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CorrespondanceRepository::class)]
#[ApiResource(normalizationContext:['groups' => ['correspondance:read']])]
class Correspondance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['correspondance:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'correspondances')]
    #[Groups(['correspondance:read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'correspondances')]
    #[Groups(['correspondance:read'])]
    private ?Animal $animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
}
