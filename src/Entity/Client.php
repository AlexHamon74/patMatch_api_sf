<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource]
class Client extends User
{
    #[ORM\Column(nullable: true)]
    private ?array $interetAnimalier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeLogement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $espaceExterieur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeEnvironnement = null;

    public function getInteretAnimalier(): ?array
    {
        return $this->interetAnimalier;
    }

    public function setInteretAnimalier(?array $interetAnimalier): static
    {
        $this->interetAnimalier = $interetAnimalier;

        return $this;
    }

    public function getTypeLogement(): ?string
    {
        return $this->typeLogement;
    }

    public function setTypeLogement(?string $typeLogement): static
    {
        $this->typeLogement = $typeLogement;

        return $this;
    }

    public function getEspaceExterieur(): ?string
    {
        return $this->espaceExterieur;
    }

    public function setEspaceExterieur(?string $espaceExterieur): static
    {
        $this->espaceExterieur = $espaceExterieur;

        return $this;
    }

    public function getTypeEnvironnement(): ?string
    {
        return $this->typeEnvironnement;
    }

    public function setTypeEnvironnement(?string $typeEnvironnement): static
    {
        $this->typeEnvironnement = $typeEnvironnement;

        return $this;
    }
}
