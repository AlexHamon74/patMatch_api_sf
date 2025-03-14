<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AnimalPersonnaliteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalPersonnaliteRepository::class)]
#[ApiResource]
class AnimalPersonnalite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'animalPersonnalites')]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'animalPersonnalites')]
    private ?Personnalite $personnalite = null;

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

    public function getPersonnalite(): ?Personnalite
    {
        return $this->personnalite;
    }

    public function setPersonnalite(?Personnalite $personnalite): static
    {
        $this->personnalite = $personnalite;

        return $this;
    }
}
