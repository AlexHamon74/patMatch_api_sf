<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\AdoptionStatus;
use App\Repository\AdoptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdoptionRepository::class)]
#[ApiResource]
class Adoption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'adoptions')]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'adoptions')]
    private ?Animal $animal = null;

    #[ORM\Column(enumType: AdoptionStatus::class)]
    private ?AdoptionStatus $status = null;

    #[ORM\Column]
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
