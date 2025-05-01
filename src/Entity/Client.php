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

    public function getInteretAnimalier(): ?array
    {
        return $this->interetAnimalier;
    }

    public function setInteretAnimalier(?array $interetAnimalier): static
    {
        $this->interetAnimalier = $interetAnimalier;

        return $this;
    }
}
